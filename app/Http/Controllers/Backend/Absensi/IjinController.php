<?php

namespace App\Http\Controllers\Backend\Absensi;

use App\Http\Controllers\Controller;
use App\Models\AbsensiIjin;
use App\Models\AbsensiIjinLines;
use App\Models\User;
use App\Services\Absensi\IjinServices;
use Illuminate\Http\Request;

class IjinController extends Controller
{
  public function __construct(IjinServices $services)
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
      'title' => 'Absensi Ijin Karyawan',
			'section' => 'absensi',
			'sub_section' => 'absensi_ijin',  
      'assets' => $assets,
			'row' => $row,
			'type' => $pluck['type'],
			'user' => $pluck['user'],
    ];

		return view('backend.absensi.ijin.index')->with($data);
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

	public function detail($kd)
	{
		$assets = array(
			'style' => array(
        'assets/css/loading.css',
				'assets/backend/libs/sweetalert2/sweetalert2.min.css'
      ),
      'script' => array(
        'assets/backend/js/plugins/printArea/jquery.PrintArea.js',
				'assets/backend/libs/sweetalert2/sweetalert2.min.js',
      )
    );

		$row = $this->service->detail($kd);

		$employee = User::find($row->users_id);

		$exp = explode('-',$row->date_start);
    $thn = $exp[0];
    $bln = $exp[1];

		$data = [
			'title' => 'Absensi Ijin Karyawan - Detail',
			'section' => 'absensi',
			'sub_section' => 'absensi_ijin',
			'get' => $row,
			'tipe' => $row->absensi_ijin_type_id,
			'bln' => $bln,
      'thn' => $thn,
			'assets' => $assets,
			'employee' => $employee
		];

		return view('backend.absensi.ijin.detail')->with($data);
	}

	public function periksa(Request $request)
	{
		$kd = $request->id;

		$code = base64_encode(time().'&'.$kd);

		$this->service->periksa($code);

		$callback = [
			'message' => 'sukses',
			'id' => $kd
		];

		echo json_encode($callback);
	}

	public function setuju(Request $request)
	{
		$kd = $request->id;

		$code = base64_encode(time().'&'.$kd);

		$this->service->setuju($code);

		$callback = [
			'message' => 'sukses',
			'id' => $kd
		];

		echo json_encode($callback);
	}

	public function ketahui(Request $request)
	{
		$kd = $request->id;

		$code = base64_encode(time().'&'.$kd);

		$this->service->ketahui($code);

		$callback = [
			'message' => 'sukses',
			'id' => $kd
		];

		echo json_encode($callback);
	}

	public function reject(Request $request)
	{
		$kd = $request->id;

		$code = base64_encode(time().'&'.$kd);

		$this->service->reject($code);

		$callback = [
			'message' => 'sukses',
			'id' => $kd
		];

		echo json_encode($callback);
	}

	public function delete($id)
	{
		AbsensiIjin::find($id)->delete();
    AbsensiIjinLines::where('absensi_ijin_id',$id)->delete();

    $alert = array(
      'type' => 'success',
      'message' => 'Ijin Karyawan berhasil di hapus'
    );
    return redirect()->back()->with($alert);
	}
}
