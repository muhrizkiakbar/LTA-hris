<?php

namespace App\Http\Controllers\Backend\Employee;

use App\Http\Controllers\Controller;
use App\Models\ResignType;
use App\Services\Employee\EmployeeServices;
use Illuminate\Http\Request;

class ResignController extends Controller
{
  public function index()
	{
		$role = auth()->user()->role_id;

		$service = new EmployeeServices;

		$assets = [
      'style' => array(
        'assets/backend/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css',
				'assets/backend/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css'
      ),
      'script' => array(
        'assets/backend/libs/datatables.net/js/jquery.dataTables.min.js',
				'assets/backend/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js'
      )
    ];

		$row = $service->getDataResign();

		$data = [
      'title' => 'Data Karyawan Resign',
			'section' => 'karyawan',
			'sub_section' => 'karyawan_resign',
      'assets' => $assets,
			'row' => $row,
			'role' => $role
    ];

		return view('backend.employee.resign.index')->with($data);
	}

	public function create(Request $request)
	{
		$id = $request->id;

		$type = ResignType::pluck('title','id');

		$data = [
			'id' => $id,
			'type' => $type
		]; 

		return view('backend.employee.detail.resign')->with($data);
	}

	public function update(Request $request)
	{
		$service = new EmployeeServices;

		$data = $request->all();

		$service->resign_interview($data);

		$alert = array(
      'type' => 'info',
      'message' => 'Pengajuan karyawan berhasil di generate'
    );

		return redirect()->route('backend.employee.resign')->with($alert);
	}
}
