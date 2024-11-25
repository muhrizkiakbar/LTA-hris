<?php

namespace App\Services\Employee;

use App\Models\Department;
use App\Models\Divisi;
use App\Models\Jabatan;
use App\Models\Lokasi;
use App\Models\Mutasi;
use App\Models\MutasiSts;
use App\Models\User;
use App\Models\UserLokasi;

class MutasiServices
{
	public function data()
	{
		$row = [];
		$users_id = auth()->user()->id;
    $role = auth()->user()->role_id;

		if ($role==1 || $role==2 || $role==3) 
		{
			$row = Mutasi::whereYear('tgl_mutasi',date('Y'))
									 ->orderBy('tgl_mutasi','DESC')
									 ->get();
		}
		else if ($role==4 || $role==11) 
		{
			$get_lokasi = UserLokasi::where('users_id', $users_id)->pluck('lokasi_id');
			$row = Mutasi::whereYear('tgl_mutasi',date('Y'))
									 ->whereIn('lokasi_id', $get_lokasi)
									 ->orderBy('tgl_mutasi','DESC')
									 ->get();
		}

		return $row;
	}

	public function select_create()
	{
		$users_id = auth()->user()->id;
		$role = auth()->user()->role_id;

		$department = Department::pluck('title','id');
		$principle = Divisi::pluck('title','id');
		$jabatan = Jabatan::pluck('title','id');

		if ($role==4 || $role==11) 
		{
			$get_lokasi = UserLokasi::where('users_id', $users_id)->pluck('lokasi_id');
			$lokasi = Lokasi::whereIn('id',$get_lokasi)->pluck('title','id');
		}
		else
		{
			$lokasi = Lokasi::pluck('title','id');
		}
		
		$mutasi = MutasiSts::pluck('title','id');
		$atasan = User::whereIn('role_id',['2','5'])
									->where('jabatan_id','<=',6)
									->orderBy('role_id','ASC')
									->orderBy('name','ASC')
									->pluck('name','id');

		$result = [
			'department' => $department,
			'principle' => $principle,
			'jabatan' => $jabatan,
			'lokasi' => $lokasi,
			'mutasi' => $mutasi,
			'atasan' => $atasan
		];

		return $result;
	}
}