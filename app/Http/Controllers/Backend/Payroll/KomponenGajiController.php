<?php

namespace App\Http\Controllers\Backend\Payroll;

use App\Http\Controllers\Controller;
use App\Models\KomponenGaji;
use App\Models\User;
use App\Services\Payroll\KomponenGajiServices;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;

class KomponenGajiController extends Controller
{
	public function __construct(KomponenGajiServices $services)
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
      'title' => 'Komponen Gaji - Karyawan',
			'section' => 'payroll',
			'sub_section' => 'payroll_komponen',  
      'assets' => $assets,
			'row' => $row
    ];

		return view('backend.payroll.komponen_gaji.index')->with($data);
	}

	public function create(Request $request)
	{
		$row = $this->service->select_create();

		$data = [
			'title' => 'Komponen Gaji - Karyawan',
			'user' => $row['user']
		];

		return view('backend.payroll.komponen_gaji.create')->with($data);
	}

	public function store(Request $request)
	{
		$name = auth()->user()->email;
    $menu = "Komponen Gaji";

		$data = $request->all();

		$post = $this->service->store($data);
		
		if ($post['message']=='success') 
		{
			$title = $name;
			$action = '<badge class="badge badge-success">INSERT DATA</badge>';
			$keterangan = "Insert data dari menu <b>" . $menu . "</b> tanggal : <b>" . date('Y-m-d') . "</b> , By : <b>" . $name . "</b>";

			history($title, $action, $keterangan);

			$alert = array(
				'type' => 'success',
				'message' => 'Komponen gaji berhasil generate'
			);
		}
		else
		{
			$alert = array(
				'type' => 'danger',
				'message' => 'Maaf, terjadi kesalahan, silahkan cek kembali'
			);
		}

		return redirect()->back()->with($alert);
	}

	public function import(Request $request)
	{
		$data = [
			'title' => 'Import - Komponen Gaji Karyawan'
		];

		return view('backend.payroll.komponen_gaji.import')->with($data);
	}

	public function import_store(Request $request)
	{
		$name = auth()->user()->email;
    $menu = "Komponen Gaji";

		$filename = $request->file('file')->getClientOriginalName();
		$request->file('file')->storeAs('public/upload/csv', $filename);
		$path = public_path('storage/upload/csv/'.$filename);

		$collection = (new FastExcel)->import($path);

		if (count($collection) > 0) 
		{
			foreach ($collection as $line) 
			{
				$user = User::where('nik',$line['nik'])->first();

				$this->service->checkActive($user->id);

				$data[] = [
					'users_id' => $user->id,
					'department_id' => $user->department_id,
					'jabatan_id' => $user->jabatan_id,
					'lokasi_id' => $user->lokasi_id,
					'gaji_pokok' => $line['gaji_pokok'],
					'tunjangan_jabatan' => $line['tunjangan_jabatan'],
					'tunjangan_makan' => $line['tunjangan_makan'],
					'tunjangan_transport' => $line['tunjangan_transport'],
					'tunjangan_sewa' => $line['tunjangan_sewa'],
					'tunjangan_pulsa' => $line['tunjangan_pulsa'],
					'tunjangan_lain' => $line['tunjangan_lain'],
					'active' => 1,
					'bpjs_except' => $line['bpjs_except'],
				];
			}

			KomponenGaji::insert($data);

			$title = $name;
			$action = '<badge class="badge badge-success">INSERT DATA</badge>';
			$keterangan = "Insert data dari menu <b>" . $menu . "</b> tanggal : <b>" . date('Y-m-d') . "</b> , By : <b>" . $name . "</b>";

			history($title, $action, $keterangan);

			$alert = array(
				'type' => 'success',
				'message' => 'Komponen gaji berhasil generate'
			);
		}
		else
		{
			$alert = array(
				'type' => 'danger',
				'message' => 'Maaf, terjadi kesalahan, silahkan cek kembali'
			);
		}

		return redirect()->back()->with($alert);
	}

	public function detail(Request $request)
	{
		$id = $request->id;

		$row = KomponenGaji::find($id);

		$data = [
			'title' => 'Detail - Komponen Gaji',
			'row' => $row
		];

		return view('backend.payroll.komponen_gaji.detail')->with($data);
	}
}
