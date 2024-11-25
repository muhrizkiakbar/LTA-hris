<?php

namespace App\Services\Payroll;

use App\Models\Department;
use App\Models\Divisi;
use App\Models\Jabatan;
use App\Models\KomponenGaji;
use App\Models\User;
use App\Models\UserLokasi;

class KomponenGajiServices
{
	public function data()
	{
		$users_id = auth()->user()->id;
    $role = auth()->user()->role_id;

		if ($role==4) 
		{
			$get_lokasi = UserLokasi::where('users_id', $users_id)->pluck('lokasi_id');
			$row = KomponenGaji::whereIn('lokasi_id', $get_lokasi)
												 ->where('active',1)
												 ->get();
		}
		else
		{
			$row = KomponenGaji::where('active',1)
												 ->get();
		}

		return $row;
	}

	public function select_create()
	{
		$users_id = auth()->user()->id;
    $role = auth()->user()->role_id;

		$department = Department::pluck('title','id');
		$jabatan = Jabatan::pluck('title','id');
		$divisi = Divisi::pluck('title','id');

		if ($role==4) 
		{
			$get_lokasi = UserLokasi::where('users_id', $users_id)->pluck('lokasi_id');
			$user = User::whereIn('lokasi_id', $get_lokasi)
									->where('role_id',5)
									->whereNull('resign_st')
									->get();
		}
		else
		{
			$user = User::where('role_id',5)
									->whereNull('resign_st')
									->get();
		}

		$result = [
			'department' => $department,
			'user' => $user,
			'jabatan' => $jabatan,
			'divisi' => $divisi
		];

		return $result;
	}

	public function store($data)
	{
		$employee = $data['employee'];

		if (count($employee) > 0) 
		{
			foreach($employee as $a)
			{
				$this->checkActive($a);

				$user = User::find($a);

				$datax[] = [
					'users_id' => $a,
					'department_id' => $user->department_id,
					'jabatan_id' => $user->jabatan_id,
					'lokasi_id' => $user->lokasi_id,
					'gaji_pokok' => $data['gaji_pokok'],
					'tunjangan_jabatan' => $data['tunjangan_jabatan'],
					'tunjangan_transport' => $data['tunjangan_transport'],
					'tunjangan_makan' => $data['tunjangan_makan'],
					'tunjangan_sewa' => $data['tunjangan_sewa'],
					'tunjangan_pulsa' => $data['tunjangan_pulsa'],
					'tunjangan_lain' => $data['tunjangan_lain'],
					'active' => 1
				];
			}

			KomponenGaji::insert($datax);

			$result = [
				'message' => 'success'
			];
		}
		else
		{
			$result = [
				'message' => 'error'
			];
		}

		return $result;
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