<?php

namespace App\Services\Employee;

use App\Models\Cabang;
use App\Models\Department;
use App\Models\Divisi;
use App\Models\Jabatan;
use App\Models\Sloting;
use App\Models\UserLokasi;

class SlotingServices
{
	public function search($department, $cabang)
	{
		if (isset($cabang)) 
		{
			$row = Sloting::where('department_id',$department)
										->where('cabang_id', $cabang)
										->orderBy('department_jabatan_id','ASC')
										->get();
		}
		else
		{
			$row = Sloting::where('department_id',$department)
										->orderBy('department_jabatan_id','ASC')
										->get();
		}

		return $row;							
	}

	public function select_index()
	{
		$users_id = auth()->user()->id;
    $role = auth()->user()->role_id;

		if ($role==4 || $role==11) 
		{
			$get_lokasi = UserLokasi::where('users_id', $users_id)->pluck('lokasi_id');
			$cabang = Cabang::whereIn('lokasi_id', $get_lokasi)->pluck('title','id');
		}
		else
		{
			$cabang = Cabang::pluck('title','id');
		}

		$department = Department::pluck('title','id');

		$result = [
			'department' => $department,
			'cabang' => $cabang
		];

		return $result;
	}

	public function select_create()
	{
		$users_id = auth()->user()->id;
    $role = auth()->user()->role_id;

		$department = Department::pluck('title','id');
		$jabatan = Jabatan::pluck('title','id');
		$divisi = Divisi::pluck('title','id');

		if ($role==4 || $role==11) 
		{
			$get_lokasi = UserLokasi::where('users_id', $users_id)->pluck('lokasi_id');
			$cabang = Cabang::whereIn('lokasi_id', $get_lokasi)->pluck('title','id');
		}
		else
		{
			$cabang = Cabang::pluck('title','id');
		}

		$result = [
			'department' => $department,
			'cabang' => $cabang,
			'jabatan' => $jabatan,
			'divisi' => $divisi
		];

		return $result;
	}
}