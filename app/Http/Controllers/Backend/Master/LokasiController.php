<?php

namespace App\Http\Controllers\Backend\Master;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use App\Services\Master\LokasiServices;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
  public function __construct(LokasiServices $services)
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

		$row = Lokasi::get();

		$data = [
      'title' => 'Lokasi',
			'section' => 'master_lokasi',
      'assets' => $assets,
			'row' => $row
    ];

		return view('backend.master.lokasi.index')->with($data);
	}

	public function store(Request $request)
	{
		$cek = Lokasi::where('title',$request->title)
								 ->get();

		if (count($cek) > 0) 
		{
			$alert = array(
				'type' => 'danger',
				'message' => 'Maaf, data telah di input !!!'
			);
		}
		else
		{
			$data = [
				'title' => $request->title,
				'kode' => $request->kode,
				'uang_makan' => $request->uang_makan
			];

			Lokasi::create($data);

			$alert = array(
				'type' => 'success',
				'message' => 'Sukses, data berhasil di input !!!'
			);
		}

		return redirect()->back()->with($alert);
	}

	public function edit(Request $request)
	{
		$id = $request->id;

		$row = Lokasi::find($id);

		$data = [
      'title' => 'Lokasi',
			'row' => $row
    ];

		return view('backend.master.lokasi.edit')->with($data);
	}

	public function update(Request $request, $id)
	{
		$data = [
			'title' => $request->title,
			'kode' => $request->kode,
			'uang_makan' => $request->uang_makan
		];

		Lokasi::find($id)->update($data);

		$alert = array(
			'type' => 'info',
			'message' => 'Sukses, data berhasil di update !!!'
		);

		return redirect()->back()->with($alert);
	}

	public function delete($id)
	{
		Lokasi::find($id)->delete();

		$alert = array(
			'type' => 'danger',
			'message' => 'Sukses, data berhasil di hapus !!!'
		);

		return redirect()->back()->with($alert);
	}
}
