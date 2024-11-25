<?php

namespace App\Http\Controllers\Backend\Master;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\DinasUangExcept;
use App\Models\Jabatan;
use App\Models\Lokasi;
use App\Models\PayrollConfig;
use App\Services\Master\DinasExceptServices;
use Illuminate\Http\Request;

class DinasExceptBiayaController extends Controller
{
  public function __construct(DinasExceptServices $services)
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

		$department = Department::pluck('title','id');
		$jabatan = Jabatan::pluck('title','id');

		$lokasi = Lokasi::pluck('title','id');

		$data = [
      'title' => 'Dinas Uang - Except',
			'section' => 'master_dinas_except',
      'assets' => $assets,
			'row' => $row,
			'department' => $department,
			'jabatan' => $jabatan,
			'lokasi' => $lokasi
    ]; 

		return view('backend.master.dinas_except.index')->with($data);
	}

	public function store(Request $request)
	{
		$cek = DinasUangExcept::where('department_id',$request->department_id)
													->where('jabatan_id',$request->jabatan_id)
													->where('lokasi_asal_id',$request->lokasi_asal_id)
													->where('lokasi_tujuan_id',$request->lokasi_tujuan_id)
													->get();
		
		if(count($cek) > 0)
		{
			$alert = array(
				'type' => 'danger',
				'message' => 'Maaf, data telah di input !!!'
			);
		}
		else
		{
			$data = $request->all();

			DinasUangExcept::create($data);

			$alert = array(
				'type' => 'success',
				'message' => 'Sukses, data berhasil di input !!!'
			);
		}

		return redirect()->back()->with($alert);
	}

	public function delete($id)
	{
		DinasUangExcept::find($id)->delete();

		$alert = array(
			'type' => 'danger',
			'message' => 'Sukses, data berhasil di hapus !!!'
		);

		return redirect()->back()->with($alert);
	}
}
