<?php

namespace App\Http\Controllers\Backend\Report;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Lokasi;
use App\Models\UserLokasi;
use App\Services\DinasServices;
use Illuminate\Http\Request;

class DinasController extends Controller
{
  public function index()
	{
		$users_id = auth()->user()->id;
    $role = auth()->user()->role_id;

		$assets = array(
      'style' => array(
				'assets/backend/css/loading.css',
				'assets/backend/libs/select2/css/select2.min.css',
				'assets/js/plugins/air-datepicker/css/datepicker.min.css',
				'assets/backend/css/custom.css'
			),
			'script' => array(
				'assets/backend/libs/select2/js/select2.min.js',
				'assets/js/plugins/notifications/sweet_alert.min.js',
				'assets/js/plugins/air-datepicker/js/datepicker.min.js',
				'assets/js/plugins/air-datepicker/js/i18n/datepicker.en.js'
			)
		);

		$department = Department::orderBy('title','ASC')
														->pluck('title','id');

		if ($role==1 || $role==2 || $role==3) 
		{
			$lokasi = Lokasi::pluck('title','id');
		}
		else
		{
			if (auth()->user()->department_id==1) 
			{
				$lokasi = Lokasi::pluck('title','id');
			}
			else
			{
				$get_lokasi = UserLokasi::where('users_id', $users_id)->pluck('lokasi_id');
				$lokasi = Lokasi::whereIn('id',$get_lokasi)->pluck('title','id');
			}
		}

		$data = [
      'title' => 'Report - Perjalanan Dinas',
			'section' => 'dinas',
			'sub_section' => 'dinas_report',
			'department' => $department,
			'lokasi' => $lokasi,
			'assets' => $assets
		];

		return view('backend.report.dinas.index')->with($data);
	}

	public function search(Request $request)
	{
		$service = new DinasServices;

		$data = $request->all();

		$view = $service->view_report_dinas($data);

		$res = [
			'row' => $view
		];

		return view('backend.report.dinas.view')->with($res);
	}
}
