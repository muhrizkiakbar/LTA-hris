<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\DepartmentJabatan;
use App\Models\Jabatan;
use App\Models\User;
use Illuminate\Http\Request;
use JWTAuth;

class ApiController extends Controller
{
	public function login(Request $request)
  {
    $input = $request->only('email', 'password');

    $token = null;

    if (!$token = JWTAuth::attempt($input)) 
    {
      return response()->json([
        'success' => false,
        'message' => 'Invalid Email or Password',
      ], 401);
    }

    $user = JWTAuth::user();
		$user_detail = User::find($user['id']);

    return response()->json([
      'success' => true,
      'user'  => [
        'id' => $user['id'],
				'nik' => $user['nik'],
        'name' => $user['name'],
        'email' => $user['email'],
				'nohp' => $user['no_hp'],
				'department' => isset($user_detail->department) ? $user_detail->department->title : '',
				'level' => isset($user_detail->lvl) ? $user_detail->lvl->title : '',
				'jabatan' => isset($user_detail->jabatan) ? $user_detail->jabatan->title : '',
				'atasan_name' => isset($user_detail->atasan) ? $user_detail->atasan->name : '',
				'atasan_email' => isset($user_detail->atasan) ? $user_detail->atasan->email : '',
				'atasan_nohp' => isset($user_detail->atasan) ? $user_detail->atasan->no_hp : '',
				'atasan_jabatan' => isset($user_detail->atasan) ? isset($user_detail->atasan->jabatan) ? $user_detail->atasan->jabatan->title : '' : ''
      ],
      'authorization' => [
        'token' => $token,
        'type' => 'bearer'
      ]
    ]);
  }

	public function getEmployee()
	{
		$data = [];

		$row = User::where('role_id', 5)->whereNull('resign_st')->get();

		foreach ($row as $item) 
		{
			$data[] = [
				'nama' => $item->name,
				'nik' => $item->nik,
				'email' => $item->email,
				'no_hp' => $item->no_hp,
				'cabang' => $item->lokasi,
				'department' => isset($item->department) ? $item->department->title : '-',
				'jabatan' => isset($item->jabatan) ? $item->jabatan->title : '-'
			];
		}

		return response()->json([
			'success' => true,
			'data' => $data
		]);
	}
	
	public function department()
	{
		$data = [];

		$department = Department::get();

		foreach ($department as $department) 
		{
			$data[] = [
				'department' => $department->title,
				'jabatan' => $this->jabatan($department->id)
			];
		}

		return response()->json([
      'success' => true,
      'data' => $data
    ]);
	}

	public function jabatan($department)
	{
		$data = [];
		
		$jabatan = Jabatan::orderBy('urutan','ASC')->get();

		foreach ($jabatan as $jabatan) 
		{
			$data[] = [
				'level' => $jabatan->title,
				'jabatan' => $this->department_jabatan($department, $jabatan->id)
			];
		}

		return $data;
	}

	public function department_jabatan($department, $jabatan)
	{
		$data = [];

		$row = DepartmentJabatan::where('department_id',$department)
														->where('jabatan_id', $jabatan)
														->get();

		foreach ($row as $value) 
		{
			$data[] = [
				'title' => $value->title
			];
		}

		return $data;
	}
}
