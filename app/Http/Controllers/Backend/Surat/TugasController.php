<?php

namespace App\Http\Controllers\Backend\Surat;

use App\Http\Controllers\Controller;
use App\Models\SuratTugas;
use App\Models\User;
use App\Services\Surat\TugasServices;
use Illuminate\Http\Request;

class TugasController extends Controller
{
  public function __construct(TugasServices $services)
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
      'title' => 'Surat Tugas',
			'section' => 'surat',
			'sub_section' => 'surat_tugas',  
      'assets' => $assets,
			'row' => $row,
			'user' => $pluck['user'],
    ];

		return view('backend.surat.tugas.index')->with($data);
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

		$get = SuratTugas::where('kd',$kd)->first();
    $date = $get->date;
    $user_id = $get->employee_id;

    $exp = explode('-', $date);
    $thn = $exp[0];
    $bln = $exp[1];

    $employee = User::find($user_id);

		$data = [
      'title' => 'Detail - Surat Tugas',
      'section' => 'surat',
      'bln' => $bln,
      'thn' => $thn,
      'employee' => $employee,
      'assets' => $assets,
      'get' => $get
    ];
    return view('backend.surat.tugas.detail')->with($data);
	}

	public function periksa(Request $request)
	{
		$kd = $request->id;
		$code = base64_encode(time().'&'.$kd);
		$post = $this->service->periksa($code);

		if ($post['message']=='sukses') 
		{
			$callback = [
				'message' => 'sukses',
				'id' => $kd
			];
		}
		else
		{
			$callback = [
				'message' => 'error'
			];
		}

		echo json_encode($callback);
	}

	public function setuju(Request $request)
	{
		$kd = $request->id;
		$code = base64_encode(time().'&'.$kd);
		$post = $this->service->setuju($code);

		if ($post['message']=='sukses') 
		{
			$callback = [
				'message' => 'sukses',
				'id' => $kd
			];
		}
		else
		{
			$callback = [
				'message' => 'error'
			];
		}

		echo json_encode($callback);
	}

	public function ketahui(Request $request)
	{
		$kd = $request->id;
		$code = base64_encode(time().'&'.$kd);
		$post = $this->service->ketahui($code);

		if ($post['message']=='sukses') 
		{
			$callback = [
				'message' => 'sukses',
				'id' => $kd
			];
		}
		else
		{
			$callback = [
				'message' => 'error'
			];
		}

		echo json_encode($callback);
	}

	public function delete($id)
	{
		$this->service->delete($id);

		$alert = array(
      'type' => 'success',
      'message' => 'Surat tugas berhasil di hapus'
    );

    return redirect()->back()->with($alert);
	}
}
