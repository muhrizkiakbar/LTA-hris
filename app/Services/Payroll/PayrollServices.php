<?php

namespace App\Services\Payroll;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\KomponenGaji;
use App\Models\Payroll;
use App\Models\PayrollLines;
use App\Models\User;
use App\Models\UserLokasi;
use DateTime;
use Illuminate\Support\Facades\DB;

class PayrollServices
{
	public function data()
	{
		$users_id = auth()->user()->id;
    $role = auth()->user()->role_id;

		if ($role==4) 
		{
			$user_lokasi = UserLokasi::where('users_id',$users_id)->pluck('lokasi_id');
			$user_distrik = User::whereIn('lokasi_id',$user_lokasi)
													->groupBy('distrik_id')
													->pluck('distrik_id');

			$get = Payroll::where('distrik_id',$user_distrik)->get();
		}
		else
		{
			$get = Payroll::get();
		}

		return $get;
	}

	public function payroll_lines($department, $payroll_id)
	{
		if (empty($department)) 
		{
			$row = PayrollLines::where('payroll_id',$payroll_id)->get();
		}
		else
		{
			$row = PayrollLines::where('payroll_id',$payroll_id)
												 ->where('department_id',$department)
												 ->get();
		}		

		return $row;
	}

	public function store($data)
	{
		$role = auth()->user()->role_id;
		$department_users = auth()->user()->department_id;
		$jabatan_users = auth()->user()->jabatan_id;

		$distrik = $data['lokasi_id'];
		$periode = $data['periode'];
		$hari_kerja = $data['hari_kerja'];

		if($role==1 || $role==3) // Role Administrator dan Root
		{
			$generate = $this->generatePayroll($periode, $distrik, $hari_kerja);

			$return = [
				'info' => $generate['info']
			];
		}
		else if ($role==5 && $department_users==1 && $jabatan_users==3)  // Role Finance Head
		{
			$generate = $this->generatePayroll($periode, $distrik, $hari_kerja);

			$return = [
				'info' => $generate['info']
			];
		}
		else
		{
			$return = [
				'info' => 'unauthorized'
			];
		}	

		return $return;
	}

	public function generatePayroll($periode, $distrik, $hari_kerja)
	{
		$datenow = date('Y-m-d');

		$convert = date('m-Y',strtotime($periode));
    $exp = explode('-',$convert);

		$bln = $exp[0];
		$thn = $exp[1];

		$end_date = $thn.'-'.$bln.'-20';
		$start_date = date('Y-m-d',strtotime($end_date.'-30 days'));
		$exp_start = explode('-',$start_date);

		$start_date2 = $exp_start[0].'-'.$exp_start[1].'-'.'21';

		$start_datex = $thn.'-'.$bln.'-01';
		
		$cek = Payroll::where('periode',$periode)->where('distrik_id',$distrik)->get();

		if (count($cek) > 0) 
		{
			$return = [
				'info' => 'already'
			];
		}
		else
		{
			$user_distrik = $this->userDistrik($distrik);
			$user_distrik_resign = $this->userDistrikResign($distrik, $periode);

			// dd($user_distrik);

			$header = [
				'distrik_id' => $distrik,
				'periode' => $periode,
				'lock' => 1
			];
	
			$payroll_header = Payroll::create($header);

			// Karyawan Active
			foreach ($user_distrik as $key => $value) 
			{
				$gaji = KomponenGaji::where('users_id',$value['users_id'])
															->where('active',1)
															->first();

				$attendance = $this->reportAbsensi($value['users_id'],$periode);
				
				if (isset($gaji)) //Ada Komponen Gaji
				{
					$tunjangan_transport = $gaji->tunjangan_transport;
					$tunjangan_makan = $gaji->tunjangan_makan;
					$gaji_pokok = $gaji->gaji_pokok;
					$tunjangan_jabatan = $gaji->tunjangan_jabatan;

					$daily_gaji_pokok = ($gaji_pokok / $hari_kerja);
					$daily_transport = ($tunjangan_transport / $hari_kerja);
					$daily_makan = ($tunjangan_makan / $hari_kerja);
					$daily_jabatan = ($tunjangan_jabatan / $hari_kerja);

					$total_tunjangan_transport = $daily_transport * $attendance['hadir'];
					$total_tunjangan_makan = $daily_makan * $attendance['hadir'];

					$tgl1 = new DateTime($value['join_date']);
					$tgl2 = new DateTime($end_date);

					$jarak = $tgl2->diff($tgl1);

					$hari = $jarak->days;

					// dd($hari);

					if ($hari < 30) 
					{
						$total_gaji_pokok = $daily_gaji_pokok * $attendance['hadir'];
						$total_tunjangan_jabatan = $daily_jabatan * $attendance['hadir'];
					}
					else
					{
						$total_gaji_pokok = $gaji_pokok;
						$total_tunjangan_jabatan = $tunjangan_jabatan;
					}

					$potongan_alpa = $daily_gaji_pokok * $attendance['alpa'];
		
					$tgl_sk = '2024-02-20';

					if ($start_date2 > $tgl_sk) 
					{
						$potongan_telat = 15400 * $attendance['telat'];
					}
					else
					{
						if ($distrik=='2') 
						{
							$potongan_telat = 15400 * $attendance['telat'];
						}
						else
						{
							$potongan_telat = 7500 * $attendance['telat'];
						}
					}

					if ($value['bpjs']=="0" && $value['bpjstk']=="0") 
					{
						$potongan_jht = 0;
						$potongan_jp = 0;
						$potongan_kes = 0;
					}
					else
					{
						$bpjs_except = !empty($gaji->bpjs_except) ? $gaji->bpjs_except : 0;

						if ($bpjs_except != 0) 
						{
							$bpjs_gapok = $bpjs_except;
						}
						else
						{
							$bpjs_gapok = $gaji_pokok;
						}

						$potongan_jht = $bpjs_gapok * 0.02;
						$potongan_jp = $bpjs_gapok > 8939000 ? 8939000 * 0.01 : $bpjs_gapok * 0.01;

						if ($value['family_lain']=='0') 
						{
							$potongan_kes = $bpjs_gapok > 12000000 ? 12000000 * 0.01 : $bpjs_gapok * 0.01;
						}
						else
						{
							$rasio_family = $value['family_lain'] * 0.01;

							$rasio = 0.01 + $rasio_family;

							$potongan_kes = $bpjs_gapok > 12000000 ? 12000000 * $rasio : $bpjs_gapok * $rasio;
						}
					}

					$potongan_absensi = $potongan_telat;

					$full_makan = $total_tunjangan_makan > 0 ? $total_tunjangan_makan : 0;
					$full_trans = $total_tunjangan_transport > 0 ? $total_tunjangan_transport : 0;

					$gaji_pokok_full = $total_gaji_pokok - $potongan_alpa;

					$pendapatan = $gaji_pokok_full + $total_tunjangan_jabatan + $full_makan + $full_trans + $gaji->tunjangan_sewa + $gaji->tunjangan_pulsa + $gaji->tunjangan_lain;

					$pph = $this->checkPercentagePph($pendapatan, $value['users_id']);

					$potongan = $potongan_absensi + $potongan_jht + $potongan_jp + $potongan_kes + $pph;

					$total_trf = $pendapatan - $potongan;
				}
				else
				{
					$tunjangan_transport = 0;
					$tunjangan_makan = 0;
					$gaji_pokok = 0;

					$daily_gaji_pokok = ($gaji_pokok / $hari_kerja);
					$daily_transport = ($tunjangan_transport / $hari_kerja);
					$daily_makan = ($tunjangan_makan / $hari_kerja);

					$total_tunjangan_transport = $daily_transport * $attendance['hadir'];
					$total_tunjangan_makan = $daily_makan * $attendance['hadir'];

					$tgl1 = new DateTime($value['join_date']);
					$tgl2 = new DateTime($datenow);

					$jarak = $tgl2->diff($tgl1);

					$hari = $jarak->days;

					// dd($hari);

					if ($hari < 30) 
					{
						$total_gaji_pokok = $daily_gaji_pokok * $attendance['hadir'];
					}
					else
					{
						$total_gaji_pokok = $gaji_pokok;
					}

					$potongan_alpa = $daily_gaji_pokok * $attendance['alpa'];
		
					$tgl_sk = '2024-02-20';

					if ($start_date2 > $tgl_sk) 
					{
						$potongan_telat = 15400 * $attendance['telat'];
					}
					else
					{
						if ($distrik=='2') 
						{
							$potongan_telat = 15400 * $attendance['telat'];
						}
						else
						{
							$potongan_telat = 7500 * $attendance['telat'];
						}
					}

					if ($value['bpjs']=="0" && $value['bpjstk']=="0") 
					{
						$potongan_jht = 0;
						$potongan_jp = 0;
						$potongan_kes = 0;
					}
					else
					{
						$bpjs_except = !empty($gaji->bpjs_except) ? $gaji->bpjs_except : 0;

						if ($bpjs_except != 0) 
						{
							$bpjs_gapok = $bpjs_except;
						}
						else
						{
							$bpjs_gapok = $gaji_pokok;
						}

						$potongan_jht = $bpjs_gapok * 0.02;
						$potongan_jp = $bpjs_gapok > 8939000 ? 8939000 * 0.01 : $bpjs_gapok * 0.01;

						if ($value['family_lain']=='0') 
						{
							$potongan_kes = $bpjs_gapok > 12000000 ? 12000000 * 0.01 : $bpjs_gapok * 0.01;
						}
						else
						{
							$rasio_family = $value['family_lain'] * 0.01;

							$rasio = 0.01 + $rasio_family;

							$potongan_kes = $bpjs_gapok > 12000000 ? 12000000 * $rasio : $bpjs_gapok * $rasio;
						}
					}

					$potongan_absensi = $potongan_telat;

					$full_makan = $total_tunjangan_makan > 0 ? $total_tunjangan_makan : 0;
					$full_trans = $total_tunjangan_transport > 0 ? $total_tunjangan_transport : 0;

					$gaji_pokok_full = $total_gaji_pokok - $potongan_alpa;

					$pendapatan = $gaji_pokok_full + 0 + $full_makan + $full_trans + 0 + 0 + 0;

					$pph = $this->checkPercentagePph($pendapatan, $value['users_id']);

					$potongan = $potongan_absensi + $potongan_jht + $potongan_jp + $potongan_kes + $pph;

					$total_trf = $pendapatan - $potongan;
				}

				$lines = [
					'periode' => $periode,
					'payroll_id' => $payroll_header->id,
					'users_id' => $value['users_id'],
					'nik' => $value['nik'],
					'department_id' => $value['department_id'],
					'jabatan_id' => $value['jabatan_id'],
					'lokasi_id' => $value['lokasi_id'],
					'join_date' => $value['join_date'],
					'attendance' => $attendance,
					'gaji_pokok' => $gaji_pokok_full,
					'tunjangan_jabatan' => isset($gaji->tunjangan_jabatan) ? isset($total_tunjangan_jabatan) ? $total_tunjangan_jabatan : 0 : 0,
					'tunjangan_makan' => $full_makan,
					'tunjangan_transport' => $full_trans,
					'tunjangan_sewa' => isset($gaji->tunjangan_sewa) ? $gaji->tunjangan_sewa : 0,
					'tunjangan_pulsa' => isset($gaji->tunjangan_pulsa) ? $gaji->tunjangan_pulsa : 0,
					'tunjangan_lain' => isset($gaji->tunjangan_lain) ? $gaji->tunjangan_lain : 0,
					'potongan_alpa' => $potongan_alpa,
					'potongan_telat' => $potongan_telat,
					'potongan_absensi' => $potongan_absensi,
					'potongan_jht' => $potongan_jht,
					'potongan_jp' => $potongan_jp,
					'potongan_kes' => $potongan_kes,
					'potongan_pph21' => $pph,
					'total_trf' => $total_trf,
					'full_pendapatan' => $pendapatan,
					'full_potongan' => $potongan,
					'mdp' => $hari_kerja,
					'daily_gaji_pokok' => $daily_gaji_pokok
				]; 

				PayrollLines::create($lines);
			}

			//Karyawan Resign
			foreach ($user_distrik_resign as $key => $value) 
			{
				$gaji = KomponenGaji::where('users_id',$value['users_id'])
														->where('active',1)
														->first();
		
				$attendance = $this->reportAbsensiResign($value['users_id'],$periode);

				if (isset($gaji)) 
				{
					$tunjangan_transport = $gaji->tunjangan_transport;
					$tunjangan_makan = $gaji->tunjangan_makan;
					$gaji_pokok = $gaji->gaji_pokok;
					$tunjangan_jabatan = $gaji->tunjangan_jabatan;

					$daily_gaji_pokok = ($gaji_pokok / $hari_kerja);
					$daily_transport = ($tunjangan_transport / $hari_kerja);
					$daily_makan = ($tunjangan_makan / $hari_kerja);
					$daily_jabatan = ($tunjangan_jabatan / $hari_kerja);

					$total_tunjangan_transport = $daily_transport * $attendance['hadir'];
					$total_tunjangan_makan = $daily_makan * $attendance['hadir'];

					$tgl1 = new DateTime($value['join_date']);
					$tgl2 = new DateTime($datenow);

					$jarak = $tgl2->diff($tgl1);

					$hari = $jarak->days;

					// dd($hari);

					$total_gaji_pokok = ($attendance['hadir'] / $hari_kerja) * $gaji_pokok;
					$total_tunjangan_jabatan = $daily_jabatan * $attendance['hadir'];
				
					$potongan_alpa = $daily_gaji_pokok * $attendance['alpa'];
		
					$tgl_sk = '2024-02-20';

					if ($start_date2 > $tgl_sk) 
					{
						$potongan_telat = 15400 * $attendance['telat'];
					}
					else
					{
						if ($distrik=='2') 
						{
							$potongan_telat = 15400 * $attendance['telat'];
						}
						else
						{
							$potongan_telat = 7500 * $attendance['telat'];
						}
					}

					if ($value['bpjs']=="0" && $value['bpjstk']=="0") 
					{
						$potongan_jht = 0;
						$potongan_jp = 0;
						$potongan_kes = 0;
					}
					else
					{
						$bpjs_except = !empty($gaji->bpjs_except) ? $gaji->bpjs_except : 0;

						if ($bpjs_except != 0) 
						{
							$bpjs_gapok = $bpjs_except;
						}
						else
						{
							$bpjs_gapok = $gaji_pokok;
						}

						$potongan_jht = $bpjs_gapok * 0.02;
						$potongan_jp = $bpjs_gapok > 8939000 ? 8939000 * 0.01 : $bpjs_gapok * 0.01;

						if ($value['family_lain']=='0') 
						{
							$potongan_kes = $bpjs_gapok > 12000000 ? 12000000 * 0.01 : $bpjs_gapok * 0.01;
						}
						else
						{
							$rasio_family = $value['family_lain'] * 0.01;

							$rasio = 0.01 + $rasio_family;

							$potongan_kes = $bpjs_gapok > 12000000 ? 12000000 * $rasio : $bpjs_gapok * $rasio;
						}
					}

					$potongan_absensi = $potongan_telat;

					$full_makan = $total_tunjangan_makan > 0 ? $total_tunjangan_makan : 0;
					$full_trans = $total_tunjangan_transport > 0 ? $total_tunjangan_transport : 0;

					$gaji_pokok_full = $total_gaji_pokok;

					$pendapatan = $gaji_pokok_full + $total_tunjangan_jabatan + $full_makan + $full_trans + $gaji->tunjangan_sewa + $gaji->tunjangan_pulsa + $gaji->tunjangan_lain;

					$pph = $this->checkPercentagePph($pendapatan, $value['users_id']);

					$potongan = $potongan_absensi + $potongan_jht + $potongan_jp + $potongan_kes + $pph;

					$total_trf = $pendapatan - $potongan;
				}
				else
				{
					$tunjangan_transport = 0;
					$tunjangan_makan = 0;
					$gaji_pokok = 0;

					$daily_gaji_pokok = ($gaji_pokok / $hari_kerja);
					$daily_transport = ($tunjangan_transport / $hari_kerja);
					$daily_makan = ($tunjangan_makan / $hari_kerja);

					$total_tunjangan_transport = $daily_transport * $attendance['hadir'];
					$total_tunjangan_makan = $daily_makan * $attendance['hadir'];

					$tgl1 = new DateTime($value['join_date']);
					$tgl2 = new DateTime($datenow);

					$jarak = $tgl2->diff($tgl1);

					$hari = $jarak->days;

					// dd($hari);

					if ($hari < 30) 
					{
						$total_gaji_pokok = $daily_gaji_pokok * $attendance['hadir'];
					}
					else
					{
						$total_gaji_pokok = $gaji_pokok;
					}

					$potongan_alpa = $daily_gaji_pokok * $attendance['alpa'];
		
					$tgl_sk = '2024-02-20';

					if ($start_date2 > $tgl_sk) 
					{
						$potongan_telat = 15400 * $attendance['telat'];
					}
					else
					{
						if ($distrik=='2') 
						{
							$potongan_telat = 15400 * $attendance['telat'];
						}
						else
						{
							$potongan_telat = 7500 * $attendance['telat'];
						}
					}

					if ($value['bpjs']=="0" && $value['bpjstk']=="0") 
					{
						$potongan_jht = 0;
						$potongan_jp = 0;
						$potongan_kes = 0;
					}
					else
					{
						$bpjs_except = !empty($gaji->bpjs_except) ? $gaji->bpjs_except : 0;

						if ($bpjs_except != 0) 
						{
							$bpjs_gapok = $bpjs_except;
						}
						else
						{
							$bpjs_gapok = $gaji_pokok;
						}

						$potongan_jht = $bpjs_gapok * 0.02;
						$potongan_jp = $bpjs_gapok > 8939000 ? 8939000 * 0.01 : $bpjs_gapok * 0.01;

						if ($value['family_lain']=='0') 
						{
							$potongan_kes = $bpjs_gapok > 12000000 ? 12000000 * 0.01 : $bpjs_gapok * 0.01;
						}
						else
						{
							$rasio_family = $value['family_lain'] * 0.01;

							$rasio = 0.01 + $rasio_family;

							$potongan_kes = $bpjs_gapok > 12000000 ? 12000000 * $rasio : $bpjs_gapok * $rasio;
						}
					}

					$potongan_absensi = $potongan_telat;

					$full_makan = $total_tunjangan_makan > 0 ? $total_tunjangan_makan : 0;
					$full_trans = $total_tunjangan_transport > 0 ? $total_tunjangan_transport : 0;

					$gaji_pokok_full = $total_gaji_pokok - $potongan_alpa;

					$pendapatan = $gaji_pokok_full + 0 + $full_makan + $full_trans + 0 + 0 + 0;

					$pph = $this->checkPercentagePph($pendapatan, $value['users_id']);

					$potongan = $potongan_absensi + $potongan_jht + $potongan_jp + $potongan_kes + $pph;

					$total_trf = $pendapatan - $potongan;
				}

				$lines = [
					'periode' => $periode,
					'payroll_id' => $payroll_header->id,
					'users_id' => $value['users_id'],
					'nik' => $value['nik'],
					'department_id' => $value['department_id'],
					'jabatan_id' => $value['jabatan_id'],
					'lokasi_id' => $value['lokasi_id'],
					'join_date' => $value['join_date'],
					'attendance' => $attendance,
					'gaji_pokok' => $gaji_pokok_full,
					'tunjangan_jabatan' => isset($gaji->tunjangan_jabatan) ? isset($total_tunjangan_jabatan) ? $total_tunjangan_jabatan : 0 : 0,
					'tunjangan_makan' => $full_makan,
					'tunjangan_transport' => $full_trans,
					'tunjangan_sewa' => isset($gaji->tunjangan_sewa) ? $gaji->tunjangan_sewa : 0,
					'tunjangan_pulsa' => isset($gaji->tunjangan_pulsa) ? $gaji->tunjangan_pulsa : 0,
					'tunjangan_lain' => isset($gaji->tunjangan_lain) ? $gaji->tunjangan_lain : 0,
					'potongan_alpa' => $potongan_alpa,
					'potongan_telat' => $potongan_telat,
					'potongan_absensi' => $potongan_absensi,
					'potongan_jht' => $potongan_jht,
					'potongan_jp' => $potongan_jp,
					'potongan_kes' => $potongan_kes,
					'potongan_pph21' => $pph,
					'total_trf' => $total_trf,
					'full_pendapatan' => $pendapatan,
					'full_potongan' => $potongan,
					'mdp' => $hari_kerja,
					'daily_gaji_pokok' => $daily_gaji_pokok
				]; 

				PayrollLines::create($lines);
			}

			$return = [
				'info' => 'success'
			];
		}

		return $return;
	}

	public function checkPercentagePph($pendapatan, $users_id)
	{
		$user = Employee::find($users_id);

		$tier = $user->ptkp_detail->tier;
		$npwp = $user->npwp_no;

		$cek = DB::table('skema_pphs')
							->selectRaw('percentage')
							->where('tier',$tier)
							->whereRaw('? BETWEEN U_FROM AND U_TO', [$pendapatan])
							->get();

		if (count($cek) > 0) 
		{
			foreach ($cek as $key => $value) 
			{
				$percentage = $value->percentage;
			}
		}
		else
		{
			$percentage = 0;
		}

		if (isset($npwp)) 
		{
			$value = ($pendapatan * $percentage);
		}
		else
		{
			$value = ($pendapatan * $percentage);
		}

		return $value;
	}

	public function userDistrik($distrik)
	{
		$row = [];

		$get = User::where('distrik_id',$distrik)
							 ->whereNull('resign_st')
							 ->get();

		foreach ($get as $key => $value) 
		{
			$row[] = [
				'users_id' => $value->id,
				'nik' => $value->nik,
				'join_date' => $value->join_date,
				'department_id' => $value->department_id,
				'jabatan_id' => $value->jabatan_id,
				'lokasi_id' => $value->lokasi_id,
				'bpjs' => $value->bpjs,
				'bpjstk' => $value->bpjstk,
				'family_lain' => $value->family_lain
			];
		}

		return $row;
	}

	public function userDistrikResign($distrik, $periode)
	{
		$row = [];

		$convert = date('m-Y',strtotime($periode));
    $exp = explode('-',$convert);

		$bln = $exp[0];
		$thn = $exp[1];

		$end_date = $thn.'-'.$bln.'-20';
		$end_date2 = date('Y-m-t',strtotime($end_date));
		$start_date = date('Y-m-d',strtotime($end_date.'-30 days'));
		$exp_start = explode('-',$start_date);

		$start_date2 = $exp_start[0].'-'.$exp_start[1].'-'.'21';

		$get = DB::table('view_employee_resign')
							 ->where('distrik_id',$distrik)
							 ->where('resign_date','>=',$start_date2)
							 ->where('resign_date','<=',$end_date2)
							 ->orderBy('jabatan_id','ASC')
							 ->get();

		foreach ($get as $key => $value) 
		{
			$row[] = [
				'users_id' => $value->id,
				'nik' => $value->nik,
				'join_date' => $value->join_date,
				'department_id' => $value->department_id,
				'jabatan_id' => $value->jabatan_id,
				'lokasi_id' => $value->lokasi_id,
				'bpjs' => $value->bpjs,
				'bpjstk' => $value->bpjstk,
				'family_lain' => $value->family_lain
			];
		}

		return $row;
	}

	function userPayroll($distrik)
	{
		$lokasi = User::where('distrik_id',$distrik)
									->groupBy('lokasi_id')
									->pluck('lokasi_id');

		$get = KomponenGaji::whereIn('lokasi_id',$lokasi)
											 ->where('active',1)
											 ->get();
	 
		return $get;
	}

	public function reportAbsensi($users_id, $periode)
	{
		$convert = date('m-Y',strtotime($periode));
    $exp = explode('-',$convert);

		$bln = $exp[0];
		$thn = $exp[1];

		$end_date = $thn.'-'.$bln.'-20';
		$start_date = date('Y-m-d',strtotime($end_date.'-30 days'));
		$exp_start = explode('-',$start_date);

		$start_date2 = $exp_start[0].'-'.$exp_start[1].'-'.'21';

		$dailyAttendance = $this->dailyAttendance($start_date2, $end_date, $users_id);

		$hadir = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'H');
		$telat = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'T');
		$sakit = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'S');
		$ijin = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'I');
		$alpa = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'A');
		$iso = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'ISO');
		$wfh = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'WFH');
		$dl = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'DL');
		$off = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'OFF');
		$lb = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'LB');
		$ct = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'CT');
		$cb = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'CB');
		$ck = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'CK');
		$pd = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'PD');

		$hadir_all = $hadir + $telat + $pd + $dl + $sakit;

		$mdp = $this->getMdpValues($start_date2,$end_date,$off);

		$mdp_all = $mdp;

		$absen = [
			'start_date' => $start_date2,
			'end_date' => $end_date,
			'hadir' => $hadir_all,
			'telat' => $telat,
			'sakit' => $sakit,
			'ijin' => $ijin,
			'alpa' => $alpa,
			'iso' => $iso,
			'wfh' => $wfh,
			'dl' => $dl,
			'off' => $off,
			'ct' => $ct,
			'cb' => $cb,
			'ck' => $ck,
			'pd' => $pd,
			'mdp' => $mdp_all
		];

		return $absen;
	}

	public function reportAbsensiResign($users_id, $periode)
	{
		$user = User::find($users_id);

		$tgl1 = "2023-04-01";
		$tgl2 = $user->join_date;

		$tgl_resign = $user->resign_date;

		if (strtotime($tgl2) > strtotime($tgl1))
		{
			$convert = date('m-Y',strtotime($periode));
			$exp = explode('-',$convert);

			$bln = $exp[0];
			$thn = $exp[1];

			$end_date = $thn.'-'.$bln.'-20';
			$start_date = date('Y-m-d',strtotime($end_date.'-30 days'));
			$exp_start = explode('-',$start_date);

			$start_date2 = $exp_start[0].'-'.$exp_start[1].'-'.'21';

			$dailyAttendance = $this->dailyAttendanceResign($start_date2, $tgl_resign, $users_id);
		}
		else
		{
			$convert = date('m-Y',strtotime($periode));
			$exp = explode('-',$convert);

			$bln = $exp[0];
			$thn = $exp[1];

			$start_date2 = $thn.'-'.$bln.'-01';
			$end_date =	 date("Y-m-t", strtotime($start_date2));

			$dailyAttendance = $this->dailyAttendanceResign($start_date2, $end_date, $users_id);
		}

		$hadir = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'H');
		$telat = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'T');
		$sakit = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'S');
		$ijin = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'I');
		$alpa = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'A');
		$iso = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'ISO');
		$wfh = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'WFH');
		$dl = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'DL');
		$off = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'OFF');
		$lb = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'LB');
		$ct = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'CT');
		$cb = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'CB');
		$ck = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'CK');
		$pd = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'PD');

		$hadir_all = $hadir + $telat + $pd + $dl + $sakit;

		$absen = [
			'start_date' => $start_date2,
			'end_date' => $end_date,
			'hadir' => $hadir_all,
			'telat' => $telat,
			'sakit' => $sakit,
			'ijin' => $ijin,
			'alpa' => $alpa,
			'iso' => $iso,
			'wfh' => $wfh,
			'dl' => $dl,
			'off' => $off,
			'ct' => $ct,
			'cb' => $cb,
			'ck' => $ck,
			'pd' => $pd
		];

		return $absen;
	}

	public function dailyAttendance($start_date, $end_date, $users_id)
	{
		$data = [];

		$row = Attendance::where('date','>=',$start_date)
										 ->where('date','<=',$end_date)
										 ->where('users_id',$users_id)
										 ->orderBy('date','ASC')
										 ->get();

		foreach ($row as $value) 
		{
			$data[] = [
				'date' => $value->date,
				'label' => $value->label
			];
		}

		return $data;
	}

	public function dailyAttendanceResign($start_date, $end_date, $users_id)
	{
		$data = [];

		$row = Attendance::where('date','>=',$start_date)
										 ->where('date','<',$end_date)
										 ->where('users_id',$users_id)
										 ->orderBy('date','ASC')
										 ->get();

		foreach ($row as $value) 
		{
			$data[] = [
				'date' => $value->date,
				'label' => $value->label
			];
		}

		return $data;
	}

	public function getLabel($value,$string) 
  {
    if (!array_key_exists($string, $value)) 
    {
      $value= 0;
    } else {
      $value = $value[$string];
    }
    return $value;
  } 

	public function getMdpValues($start_date,$end_date,$off)
  {
		// Tanggal awal
		$tanggal_awal = new DateTime($start_date);

		// Tanggal akhir
		$tanggal_akhir = new DateTime($end_date);

		$selisih_hari = $tanggal_awal->diff($tanggal_akhir)->days;

    $result = $selisih_hari - $off;
    return $result;
  }

	public function update_payroll($data)
	{
		// dd($data);

		$index = $data['idx'];
		$tunjangan_makan = $data['tunjangan_makan'];
		$tunjangan_transport = $data['tunjangan_transport'];
		$tunjangan_sewa = $data['tunjangan_sewa'];
		$lembur = $data['lembur'];
		$id = $data['id'];

		foreach ($index as $key => $value) 
		{
			$gaji = PayrollLines::find($id[$key]);

			$full_pendapatan = $gaji->gaji_pokok + $gaji->tunjangan_jabatan + $tunjangan_makan[$key] + $tunjangan_transport[$key] + $tunjangan_sewa[$key] + $gaji->lembur + $gaji->thr;
			$full_potongan = $gaji->full_potongan + $gaji->potongan_batal_nota;

			$full_trf = $full_pendapatan - $full_potongan;

			$lines = [
				'tunjangan_makan' => $tunjangan_makan[$key],
				'tunjangan_transport' => $tunjangan_transport[$key],
				'tunjangan_sewa' => $tunjangan_sewa[$key],
				'full_pendapatan' => $full_pendapatan,
				'full_potongan' => $full_potongan,
				'total_trf' => $full_trf
			];

			PayrollLines::find($id[$key])->update($lines);
		}

		// dd($lines);
	}

	public function export($payroll_id)
	{
		$data = PayrollLines::where('payroll_id',$payroll_id)->get();

		$res = collect($data)->transform(function($item) {
      return [
				'NIK' => $item->nik,
				'Nama Karyawan' => $item->user_detail->name,
				'Lokasi' => $item->lokasi,
				'Department' => $item->department->title,
				'Jabatan' => $item->jabatan->title,
				'Posisi' => $item->user_detail->jabatan->title,
				'Gaji Pokok' => (float) $item->gaji_pokok,
				'Tunjangan Jabatan' => (float) $item->tunjangan_jabatan,
				'Uang Makan' => (float) $item->tunjangan_makan,
				'Uang Transport' => (float) $item->tunjangan_transport,
				'Tunjangan Sewa Rumah' => (float) $item->tunjangan_sewa,
				'Tunjangan Pulsa' => (float) $item->tunjangan_pulsa,
				'Tunjangan Lainnya' => (float) $item->tunjangan_lain,
				'Incentive REG' => (float) $item->incentive_reg,
				'Incentive GM' => (float) $item->incentive_gm,
				'Incentive Klaim Principal' => (float) $item->principal,
				'Lembur' => (float) $item->lembur,
				'THR' => (float) $item->thr,
				'Transfer Tgl 15' => (float) $item->trf15,
				'Total Pendapatan' => (float) $item->full_pendapatan,
				'Potongan Absensi' => (float) $item->potongan_absensi,
				'Potongan JHT' => (float) $item->potongan_jht,
				'Potongan JP' => (float) $item->potongan_jp,
				'Potongan Kesehatan' => (float) $item->potongan_kes,
				'Potongan PPH 21' => (float) $item->potongan_pph21,
				'Potongan Pinjaman' => (float) $item->potongan_pinjaman,
				'Potongan Batal Nota' => (float) $item->potongan_batal_nota,
				'Total Potongan' => (float) $item->full_potongan,
				'Total Transfer' => (float) $item->total_trf,
				'Claim Principal' => isset($item->user_detail) ? isset($item->user_detail->claim_principal) ? $item->user_detail->claim_principal->title : '-' : '-'
			];
		});

		$result = [
      'data' => $res
    ];

    return $result;
	}
}