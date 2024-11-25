<?php

namespace App\Http\Controllers\Backend\Report;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Lokasi;
use App\Services\Absensi\AbsensiServices;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
  public function index()
	{
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
		
		$lokasi = Lokasi::pluck('title','id');

		$data = [
      'title' => 'Report - Absensi Karyawan',
			'section' => 'absensi',
			'sub_section' => 'absensi_report',
			'department' => $department,
			'lokasi' => $lokasi,
			'assets' => $assets
		];

		return view('backend.report.absensi.index')->with($data);
	}

	public function generate(Request $request)
	{
		$service = new AbsensiServices;

		$data = $request->all();

		$service->generate_report_absensi($data);
	}
	

	public function search(Request $request)
	{
		$service = new AbsensiServices;

		$data = $request->all();

		$view = $service->view_report_absensi($data);

		$data = [
			'absen' => $view['absen'],
			'hari' => $view['hari'],
			'department' => $view['department'],
			'lokasi' => $view['lokasi'],
			'sum_hadir' => $view['sum_hadir'],
      'sum_telat' => $view['sum_telat'],
      'sum_sakit' => $view['sum_sakit'],
      'sum_ijin' => $view['sum_ijin'],
      'sum_alpa' => $view['sum_alpa'],
      'sum_iso' => $view['sum_iso'],
      'sum_wfh' => $view['sum_wfh'],
      'sum_dl' => $view['sum_dl'],
      'sum_off' => $view['sum_off'],
      'sum_ct' =>$view['sum_ct'],
      'sum_cb' => $view['sum_cb'],
      'sum_ck' => $view['sum_ck'],
      'sum_pd' => $view['sum_pd'],
      'sum_mdp' => $view['sum_mdp'],
      'sum_mda' => $view['sum_mda'],
      'sum_mdl' => $view['sum_mdl'],
      'sum_hari' => $view['sum_hari'],
      'ratio' =>  $view['ratio']
		];

		return view('backend.report.absensi.view')->with($data);
	}

	public function resign()
	{
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
		
		$lokasi = Lokasi::pluck('title','id');

		$data = [
      'title' => 'Report - Absensi Karyawan Resign',
			'section' => 'absensi',
			'sub_section' => 'absensi_report',
			'department' => $department,
			'lokasi' => $lokasi,
			'assets' => $assets
		];

		return view('backend.report.absensi.resign')->with($data);
	}

	public function resign_generate(Request $request)
	{
		$service = new AbsensiServices;

		$data = $request->all();

		$service->generate_report_absensi_resign($data);
	}

	public function resign_search(Request $request)
	{
		$service = new AbsensiServices;

		$data = $request->all();

		$view = $service->view_report_absensi_resign($data);

		$data = [
			'absen' => $view['absen'],
			'hari' => $view['hari'],
			'department' => $view['department'],
			'lokasi' => $view['lokasi'],
			'sum_hadir' => $view['sum_hadir'],
      'sum_telat' => $view['sum_telat'],
      'sum_sakit' => $view['sum_sakit'],
      'sum_ijin' => $view['sum_ijin'],
      'sum_alpa' => $view['sum_alpa'],
      'sum_iso' => $view['sum_iso'],
      'sum_wfh' => $view['sum_wfh'],
      'sum_dl' => $view['sum_dl'],
      'sum_off' => $view['sum_off'],
      'sum_ct' =>$view['sum_ct'],
      'sum_cb' => $view['sum_cb'],
      'sum_ck' => $view['sum_ck'],
      'sum_pd' => $view['sum_pd'],
      'sum_mdp' => $view['sum_mdp'],
      'sum_mda' => $view['sum_mda'],
      'sum_mdl' => $view['sum_mdl'],
      'sum_hari' => $view['sum_hari'],
      'ratio' =>  $view['ratio']
		];

		return view('backend.report.absensi.resign_view')->with($data);
	}
}
