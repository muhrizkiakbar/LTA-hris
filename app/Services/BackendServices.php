<?php

namespace App\Services;

use App\Models\Distrik;
use App\Models\Employee;
use App\Models\UserLokasi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BackendServices 
{
	public function resend_wa($data)
	{
		$no_wa = $data['no_wa'];

		$message = sprintf("%s \n\n%s \n\n%s \n\n%s \n\nTerima Kasih", $data['subject'], $data['new_message'], $data['teks_tengah'], $data['teks_otp']);
		return callWhatsapp2($no_wa, $message);
	}

	public function expired_kontrak()
	{
		$role = auth()->user()->role_id;
		$users_id = auth()->user()->id;

		$datenow = date("Y-m-d");
		$tglto= date('Y-m-d', strtotime("+1 months", strtotime($datenow)));
		$tglfrom = "1970-01-02";

		if($role == 1 || $role == 2)
		{
			$row = DB::table('view_kontrak_kerja')
						 	 ->where('expired_date','>=',$tglfrom)
							 ->where('expired_date','<=',$tglto)
							 ->whereIn('kontrak_id',[2,3])
							 ->get();
		}
		else
		{
			$get_lokasi = UserLokasi::where('users_id', $users_id)->pluck('lokasi_id');
			$row = DB::table('view_kontrak_kerja')
								->where('expired_date','>=',$tglfrom)
								->where('expired_date','<=',$tglto)
								->whereIn('lokasi_id',$get_lokasi)
								->whereIn('kontrak_id',[2,3])
								->get();

		}

		return $row;
	}

	public function group_kontrak()
	{
		$data = [];

		$role = auth()->user()->role_id;
		$users_id = auth()->user()->id;

		if ($role == 1 || $role == 2) 
		{
			$row = DB::table('view_kontrak_kerja')
								->selectRaw('SUM(active) AS total, kontrak, label')
								->groupBy('kontrak')
								->groupBy('label')
								->get();
		}
		else
		{
			$get_lokasi = UserLokasi::where('users_id', $users_id)->pluck('lokasi_id');
			$row = DB::table('view_kontrak_kerja')
								->selectRaw('SUM(active) AS total, kontrak, label')
								->whereIn('lokasi_id',$get_lokasi)
								->groupBy('kontrak')
								->groupBy('label')
								->get();
		}

		foreach ($row as $key => $value) 
		{
			$data[] = [
				'kontrak' => $value->kontrak,
				'label' => $value->label,
				'total' => $value->total,
			];
		}

		return $data;
	}

	public function karyawan_gender()
	{
		$data = [];

		$role = auth()->user()->role_id;
		$users_id = auth()->user()->id;

		if ($role == 1 || $role == 2) 
		{
			$row = DB::table('view_karyawan_raw')
								->selectRaw('SUM(active) AS total, gender')
								->groupBy('gender')
								->get();
		}
		else
		{
			$get_lokasi = UserLokasi::where('users_id', $users_id)->pluck('lokasi_id');
			$row = DB::table('view_karyawan_raw')
								->selectRaw('SUM(active) AS total, gender')
								->whereIn('lokasi_id',$get_lokasi)
								->groupBy('gender')
								->get();
		}

		foreach ($row as $key => $value) 
		{
			$data[] = [
				'label' => $value->gender,
				'total' => $value->total
			];
		}

		return $data;
	}

	public function range_ages()
	{
		$karyawan = Employee::where('role_id',5)
												->where('resign_st',NULL)
												->get();

    $umurCounts = [];
		$row = [];

		foreach ($karyawan as $pegawai) 
		{
			$tanggalLahir = Carbon::parse($pegawai->tgl_lahir);
			$umur = Carbon::now()->diffInYears($tanggalLahir);

			if ($umur > 20) 
			{
				$range = floor($umur / 10) * 10;
			}
			else
			{
				$range = 20;
			}
			
			$umurCounts[$range] = isset($umurCounts[$range]) ? $umurCounts[$range] + 1 : 1;
		}

		$umurs = collect($umurCounts)->keys()->sort()->values();

		foreach ($umurs as $umur) 
		{
			$row[] = [
				'x' => "Umur ".$umur."an",
				'y' => $umurCounts[$umur]
			];
		}


		$data = [
			'row' => $row
		];

		return $data;
	}

	public function chart_absensi()
	{
		$distrik = Distrik::get();

		$row = [];

	foreach ($distrik as $distrik)
		{
			$row[] = [
				'label' => $distrik->title,
				'total_izin' => $this->get_absensi_qty($distrik->id, 'I'),
				'total_sakit' => $this->get_absensi_qty($distrik->id, 'S'),
				'total_alpa' => $this->get_absensi_qty($distrik->id, 'A')
			];
		}

		return $row;
	}

	public function get_absensi_qty($distrik, $label)
	{
		$sum = DB::table('view_absensi_todate')
						 ->where('distrik_id',$distrik)
						 ->where('label',$label)
						 ->sum('active');

		return $sum!=0 ? $sum : 0; 
	}
}
