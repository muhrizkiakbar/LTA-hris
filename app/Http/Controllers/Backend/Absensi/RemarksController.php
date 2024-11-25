<?php

namespace App\Http\Controllers\Backend\Absensi;

use App\Http\Controllers\Controller;
use App\Services\Absensi\RemarksServices;
use Illuminate\Http\Request;

class RemarksController extends Controller
{
  public function __construct(RemarksServices $services)
	{
		$this->service = $services;
	}

	public function index()
	{
		$assets = [
      'style' => array(
				'assets/backend/libs/select2/css/select2.min.css',
        'assets/backend/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css',
				'assets/backend/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css',
				'assets/js/plugins/air-datepicker/css/datepicker.min.css'
      ),
      'script' => array(
				'assets/backend/libs/select2/js/select2.min.js',
        'assets/backend/libs/datatables.net/js/jquery.dataTables.min.js',
				'assets/backend/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js',
				'assets/js/plugins/air-datepicker/js/datepicker.min.js',
				'assets/js/plugins/air-datepicker/js/i18n/datepicker.en.js'
      )
    ];

		$row = $this->service->data();
		$pluck = $this->service->pluck_data();

		$data = [
      'title' => 'Absensi Remarks',
			'section' => 'absensi',
			'sub_section' => 'absensi_remarks',  
      'assets' => $assets,
			'row' => $row,
			'user' => $pluck['user'],
    ];

		return view('backend.absensi.remarks.index')->with($data);
	}

	public function store(Request $request)
	{
		$data = $request->all();

		$this->service->store($data);

		$alert = array(
      'type' => 'info',
      'message' => 'Data berhasil di input'
    );

    return redirect()->back()->with($alert);
	}

	public function delete($id)
	{
		$this->service->delete($id);

		$alert = array(
      'type' => 'info',
      'message' => 'Data berhasil di hapus !!!'
    );

    return redirect()->back()->with($alert);
	}
}
