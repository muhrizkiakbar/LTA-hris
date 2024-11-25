<?php

namespace App\Http\Controllers\Backend\Report;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Lokasi;
use App\Models\UserLokasi;
use App\Services\Employee\EmployeeServices;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
  public function __construct(EmployeeServices $service)
	{
		$this->service = $service;
	}

	public function karyawan()
	{
		$users_id = auth()->user()->id;
		$role = auth()->user()->role_id;

		$assets = [
      'style' => array(
        'assets/css/loading.css',
				'assets/backend/libs/select2/css/select2.min.css',
      ),
      'script' => array(
        'assets/js/plugins/notifications/sweet_alert.min.js',
				'assets/backend/libs/select2/js/select2.min.js',
      )
    ];

		$department = Department::pluck('title','id');

		if ($role==4 || $role==11) 
		{
			$get_lokasi = UserLokasi::where('users_id', $users_id)->pluck('lokasi_id');
			$lokasi = Lokasi::whereIn('id',$get_lokasi)->pluck('title','id');
		}
		else
		{
			$lokasi = Lokasi::pluck('title','id');
		}

		$data = [
      'title' => 'Report Data Karyawan',
			'section' => 'karyawan',
			'sub_section' => 'report',
			'assets' => $assets,
			'department' => $department,
			'lokasi' => $lokasi
    ];

		return view('backend.report.employee.karyawan')->with($data);
	}

	public function karyawan_search(Request $request)
	{
		$data = [
			'lokasi' => $request->lokasi,
			'department' => $request->department
		];

		// dd($data);

		$row = $this->service->report_karyawan($data);

		$res = [
			'row' => $row
		];

		return view('backend.report.employee.karyawan_view')->with($res);
	}

	public function karyawan_edit(Request $request)
	{
		
	}

	public function karyawan_update(Request $request, $id)
	{
		
	}

	public function kelengkapan()
	{
		$users_id = auth()->user()->id;
		$role = auth()->user()->role_id;

		$assets = [
      'style' => array(
        'assets/css/loading.css',
				'assets/backend/libs/select2/css/select2.min.css',
      ),
      'script' => array(
        'assets/js/plugins/notifications/sweet_alert.min.js',
				'assets/backend/libs/select2/js/select2.min.js',
      )
    ];

		$department = Department::pluck('title','id');

		if ($role==4 || $role==11) 
		{
			$get_lokasi = UserLokasi::where('users_id', $users_id)->pluck('lokasi_id');
			$lokasi = Lokasi::whereIn('id',$get_lokasi)->pluck('title','id');
		}
		else
		{
			$lokasi = Lokasi::pluck('title','id');
		}

		$data = [
      'title' => 'Report Kelengkapan Dokumen Karyawan',
			'section' => 'karyawan',
			'sub_section' => 'report',
			'assets' => $assets,
			'department' => $department,
			'lokasi' => $lokasi
    ];

		return view('backend.report.employee.kelengkapan')->with($data);
	}

	public function kelengkapan_search(Request $request)
	{
		$data = [
			'lokasi' => $request->lokasi,
			'department' => $request->department
		];

		// dd($data);

		$row = $this->service->report_karyawan($data);

		$res = [
			'row' => $row
		];

		return view('backend.report.employee.kelengkapan_view')->with($res);
	}
}
