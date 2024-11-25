<?php

namespace App\Http\Controllers\Backend\Employee;

use App\Http\Controllers\Controller;
use App\Models\Mutasi;
use App\Models\User;
use App\Services\Employee\MutasiServices;
use Illuminate\Http\Request;

class MutasiController extends Controller
{
	public function __construct(MutasiServices $service)
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
      'title' => 'Mutasi Karyawan',
			'section' => 'karyawan',
			'sub_section' => 'mutasi',  
      'assets' => $assets,
			'row' => $row
    ];

		return view('backend.employee.mutasi.index')->with($data);
	}

	public function create(Request $request)
	{
		$row = $this->service->select_create();

		$data = [
      'title' => 'Tambah Data - Mutasi Karyawan',
			'department' => $row['department'],
			'divisi' => $row['principle'],
			'jabatan' => $row['jabatan'],
			'lokasi' => $row['lokasi'],
			'mutasi' => $row['mutasi'],
			'atasan' => $row['atasan']
    ];

		return view('backend.employee.mutasi.create')->with($data);
	}

	public function store(Request $request)
	{
		// dd($request->all());

		$name = auth()->user()->email;
    $menu = "Mutasi Jabatan Karyawan";

		$arr = $request->users_id;

    $get = User::find($arr);
		$nama = $get->nama;

		$data = [
			'user_id' => $arr,
			'department_id' => $request->department_id,
			'divisi_id' => $request->divisi_id,
			'm_jabatan_id' => $request->m_jabatan_id,
			'm_department_jabatan_id' => $request->m_department_jabatan_id,
			'tgl_mutasi' => $request->tgl_mutasi,
			'mutasi_sts_id' => $request->mutasi_sts_id,
			'atasan_id' => $request->atasan_id,
			'status' => 1,
			'lokasi_id' => $request->lokasi_id
		];

		$data2 = [
			'department_id' => $request->department_id,
			'divisi_id' => $request->divisi_id,
			'jabatan_id' => $request->m_jabatan_id,
			'department_jabatan_id' => $request->m_department_jabatan_id,
			'atasan_id' => $request->atasan_id,
			'lokasi_id' => $request->lokasi_id
		];

		User::find($arr)->update($data2);

		$cek = Mutasi::where('user_id', $arr)->where('status', 1)->orderBy('id', 'DESC')->limit(1);

		if ($cek->count() > 0) {
			$cek_data = $cek->first();
			$last_id = $cek_data->id;

			$ubah_st = ['status' => 0];
			$ubah = Mutasi::find($last_id)->update($ubah_st);
			if ($ubah) {
				$post = Mutasi::create($data);
				if($post)
				{
					User::where('id',$arr)->update($data2);
				}
			}
		} else {
			$post = Mutasi::create($data);
			if($post)
			{
				User::where('id',$arr)->update($data2);
			}
		}

		$title = $name;
		$action = '<badge class="badge badge-success">INSERT DATA</badge>';
		$keterangan = "Insert data Mutasi Jabatan Karyawan dari menu <b>" . $menu . "</b> dengan title : <b>" . $nama . "</b> , By : <b>" . $name . "</b>";

		history($title, $action, $keterangan);

		$alert = array(
      'type' => 'success',
      'message' => 'Mutasi berhasil di input'
    );

    return redirect()->back()->with($alert);
	}

	public function employee_department(Request $request)
	{
		$department = $request->lokasi_karyawan;

    $get = User::where('lokasi_id',$department)
							 ->where('resign_st',NULL)
							 ->orderBy('jabatan_id','ASC')
							 ->orderBy('name','ASC')
							 ->get();

		$list = "<option value=''>-- Pilih Karyawan --</option>";
		foreach ($get as $key) {
			$list .= "<option value='" . $key->id . "'>" . $key->name . "</option>";
		}
		$callback = array('listdoc' => $list);
		echo json_encode($callback);
	}
}
