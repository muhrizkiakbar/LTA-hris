<?php

namespace App\Http\Controllers\Backend\Cuti;

use App\Http\Controllers\Controller;
use App\Models\CutiLines;
use App\Services\Cuti\LiburServices;
use Illuminate\Http\Request;

class LiburController extends Controller
{
  public function __construct(LiburServices $service)
	{
		$this->service = $service;
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

		$data = [
      'title' => 'Tanggal Libur',
			'section' => 'cuti',
			'sub_section' => 'cuti_libur',  
      'assets' => $assets,
			'row' => $row
    ];

		return view('backend.cuti.libur.index')->with($data);
	}

	public function store(Request $request)
	{
		$name = auth()->user()->email;
    $menu = "Tanggal Libur";

		$data = $request->all();

		$post = $this->service->post($data);

		if ($post['message']=='sukses') 
		{
			$title = $name;
			$action = '<badge class="badge badge-success">INSERT DATA</badge>';
			$keterangan = "Input data baru dari menu <b>" . $menu . "</b> tanggal : <b>" . $request->date . "</b> dengan deskripsi <b>" . $request->desc . "</b> , By : <b>" . $name . "</b>";

			history($title, $action, $keterangan);

			$alert = array(
				'type' => 'info',
				'message' => 'Data berhasil di input'
			);
		}
		else
		{
			$alert = array(
				'type' => 'danger',
				'message' => 'Maaf, data sudah di input !'
			);
		}
		
    return redirect()->back()->with($alert);
	}

	public function delete($id)
	{
		$name = auth()->user()->email;
    $menu = "Tanggal Libur";

    $get = CutiLines::find($id);
    $date = $get->date;

		$this->service->delete($id);

    $title = $name;
    $action = '<badge class="badge badge-danger">DELETE DATA</badge>';
    $keterangan = "Delete data dari menu <b>" . $menu . "</b> tanggal : <b>" . $date . "</b> , By : <b>" . $name . "</b>";

    history($title, $action, $keterangan);

    $alert = array(
      'type' => 'danger',
      'message' => 'Data berhasil di dihapus'
    );

    return redirect()->back()->with($alert);
	}
}
