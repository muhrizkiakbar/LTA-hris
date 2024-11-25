<?php

namespace App\Http\Controllers\Backend\Master;

use App\Http\Controllers\Controller;
use App\Models\DinasLokasiJarak;
use App\Models\Lokasi;
use App\Services\Master\DinasLokasiServices;
use Illuminate\Http\Request;

class DinasLokasiController extends Controller
{
	public function __construct(DinasLokasiServices $services)
	{
		$this->service = $services;
	}

	public function index()
	{
		$assets = [
      'style' => array(
				'assets/backend/libs/select2/css/select2.min.css',
        'assets/backend/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css',
				'assets/backend/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css'
      ),
      'script' => array(
				'assets/backend/libs/select2/js/select2.min.js',
        'assets/backend/libs/datatables.net/js/jquery.dataTables.min.js',
				'assets/backend/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js'
      )
    ];

		$row = $this->service->data();

		$data = [
      'title' => 'Dinas Lokasi Jarak',
			'section' => 'master_dinas_lokasi',
      'assets' => $assets,
			'row' => $row
    ];

		return view('backend.master.dinas_lokasi.index')->with($data);
	}

	public function edit(Request $request)
	{
		$id = $request->id;

		$detail = $this->service->detail($id);

		$lokasi = Lokasi::pluck('title','id');

		$data = [
			'title' => 'Dinas Lokasi Jarak',
			'row' => $detail,
			'lokasi' => $lokasi
		];

		return view('backend.master.dinas_lokasi.edit')->with($data);
	}

	public function update(Request $request, $id)
	{
		DinasLokasiJarak::find($id)->update($request->all());

		$alert = array(
			'type' => 'success',
			'message' => 'Update berhasil di lakukan !!!'
		);

		return redirect()->back()->with($alert);
	}

	public function delete($id)
	{
		DinasLokasiJarak::find($id)->delete();

		$alert = array(
			'type' => 'success',
			'message' => 'Delete berhasil di lakukan !!!'
		);

		return redirect()->back()->with($alert);
	}
}
