<?php

namespace App\Services\Employee;

use App\Models\Employee;
use App\Models\EmployeeSts;
use App\Models\KomponenGaji;
use App\Models\KontrakKerja;
use App\Models\User;
use App\Models\UserLokasi;

class KontrakKerjaServices
{
	public function data()
	{
		$row = [];
		$users_id = auth()->user()->id;
    $role = auth()->user()->role_id;

		if ($role==1 || $role==2 || $role==3) 
		{
			$row = KontrakKerja::select(
														"users.nik as nik",
														"users.name as name",
														"kontrak_kerja.tgl_start",
														"kontrak_kerja.tgl_end",
														"m_employee_sts.title as status",
														"kontrak_kerja.id"
													)
												->leftJoin("users", "users.id", "=", "kontrak_kerja.user_id")
												->leftJoin("m_employee_sts", "m_employee_sts.id", "=", "kontrak_kerja.employee_sts_id")
												->orderBy('kontrak_kerja.id','DESC')
												->get();
		}
		else if ($role==4 || $role==11) 
		{
			$get_lokasi = UserLokasi::where('users_id', $users_id)->pluck('lokasi_id');
			$row = KontrakKerja::select(
														"users.nik as nik",
														"users.name as name",
														"kontrak_kerja.tgl_start",
														"kontrak_kerja.tgl_end",
														"m_employee_sts.title as status",
														"kontrak_kerja.id"
													)
												->leftJoin("users", "users.id", "=", "kontrak_kerja.user_id")
												->leftJoin("m_employee_sts", "m_employee_sts.id", "=", "kontrak_kerja.employee_sts_id")
												->whereIn('users.lokasi_id',$get_lokasi)
												->orderBy('kontrak_kerja.id','DESC')
												->get();

		}

		return $row;
	}

	public function store($data, $file)
	{
		$name = auth()->user()->email;
    $menu = "Kontrak Kerja Karyawan";

		$user_id = $data['user_id'];
		$sts =$data['employee_sts_id'];

		if ($sts != 4) {
      $tgl_start =  $data['tgl_start'];
      $tgl_end = $data['tgl_end'];
    } else {
      $tgl_start = $data['tgl_start'];
      $tgl_end = date('Y-m-d');
    }

		$get = Employee::find($user_id);
		$nama = $get->nama;

		$this->cek_kontrak($user_id);

		$datax = [
			'user_id' => $user_id,
			'employee_sts_id' => $sts,
			'tgl_start' => $tgl_start,
			'tgl_end' => $tgl_end,
			'status' => 1,
			'dokumen' => $file
		];

		KontrakKerja::create($datax);

		$this->generate_komponen_gaji($user_id, $data);

		$title = $name;
		$action = '<badge class="badge badge-success">INSERT DATA</badge>';
		$keterangan = "Insert data Kontrak Kerja Karyawan dari menu <b>" . $menu . "</b> dengan title : <b>" . $nama . "</b> , By : <b>" . $name . "</b>";

		history($title, $action, $keterangan);
	}

	public function cek_kontrak($id)
	{
		$cek = KontrakKerja::where('user_id', $id)
											 ->where('status', 1)
											 ->first();

		if (isset($cek)) 
		{
			$last_id = $cek->id;

			if (isset($last_id)) 
			{
				$ubah_st = ['status' => 0];
				return KontrakKerja::find($last_id)->update($ubah_st);
			}
		}
	}

	public function generate_komponen_gaji($user_id, $data)
	{
		$this->checkActive($user_id);

		$user = User::find($user_id);

		$data_komponen_gaji = [
			'users_id' => $user_id,
			'department_id' => $user->department_id,
			'jabatan_id' => $user->jabatan_id,
			'lokasi_id' => $user->lokasi_id,
			'gaji_pokok' => isset($data['gaji_pokok']) ? $data['gaji_pokok'] : 0,
			'tunjangan_jabatan' => isset($data['tunjangan_jabatan']) ? $data['tunjangan_jabatan'] : 0,
			'tunjangan_makan' => isset($data['tunjangan_makan']) ? $data['tunjangan_makan'] : 0,
			'tunjangan_transport' => isset($data['tunjangan_transport']) ? $data['tunjangan_transport'] : 0,
			'tunjangan_sewa' => isset($data['tunjangan_sewa']) ? $data['tunjangan_sewa'] : 0,
			'tunjangan_pulsa' => isset($data['tunjangan_pulsa']) ? $data['tunjangan_pulsa'] : 0,
			'tunjangan_lain' => isset($data['tunjangan_lain']) ? $data['tunjangan_lain'] : 0,
			'active' => 1
		];

		KomponenGaji::create($data_komponen_gaji);
	}

	public function checkActive($id)
	{
		$cek = KomponenGaji::where('users_id',$id)
											 ->where('active',1)
											 ->first();

		if (isset($cek)) 
		{
			$data = [
				'active' => 0
			];

			return KomponenGaji::find($cek->id)->update($data);
		}
	}
}