<?php

namespace App\Http\Controllers\Backend\Employee;

use App\Http\Controllers\Controller;
use App\Models\Sp;
use App\Models\SuratPeringatan;
use App\Models\User;
use App\Services\Employee\SuratPeringatanServices;
use Illuminate\Http\Request;

class SuratPeringatanController extends Controller
{
	public function __construct(SuratPeringatanServices $service)
	{
		$this->service = $service;
	}
	
  public function index(Request $request)
	{
		$assets = [
      'style' => array(
        'assets/css/loading.css',
				'assets/backend/libs/select2/css/select2.min.css',
      ),
      'script' => array(
				'assets/backend/libs/select2/js/select2.min.js',
        'assets/js/plugins/notifications/sweet_alert.min.js',
      )
    ];

		$sp = Sp::pluck('title','id');

		$data = [
      'title' => 'Surat Peringatan',
			'section' => 'karyawan',
			'sub_section' => 'surat_peringatan',
			'sp' => $sp,
			'assets' => $assets,
			'id' => $request->id
		];

		return view('backend.employee.detail.surat_peringatan')->with($data);
	}

	public function store(Request $request)
	{
		$name = auth()->user()->email;
    $menu = "Data Surat Peringatan";
		
    $id = $request->users_id;
    $type = $request->m_sp_id;
    $date = $request->date;

		$durasi = "+6 month";
    $expired = date('Y-m-d', strtotime($durasi, strtotime($request->date)));

		$data = [
      'users_id' => $id,
      'date' => $date,
      'expired' => $expired,
      'm_sp_id' => $type,
      'pelanggaran' => $request->pelanggaran,
      'nomor' => $request->nomor
    ];

    SuratPeringatan::create($data);

		$title = $name;
    $action = '<badge class="badge badge-success">GENERATE SURAT PERINGATAN</badge>';
    $keterangan = "Upload data dari menu <b>" . $menu . "</b> dengan pelanggaran : <b>" . $request->pelanggaran . "</b> , By : <b>" . $name . "</b>";

    history($title, $action, $keterangan);

    $alert = array(
      'type' => 'info',
      'message' => 'Data berhasil di input'
    );

    return redirect()->route('backend.employee.detail', $id)->with($alert);
	}

	public function view($id)
	{
		$get = SuratPeringatan::find($id);

    $manager_id = get_cuti_setujui($get->user->atasan_id, $get->user->lokasi_id);
    $get_manager = User::find($manager_id);

    $data = [
      'nomor' => $get->nomor,
      'sp' => $get->sp->title,
      'user' => $get->user,
      'manager' => $get_manager,
      'pelanggaran' => $get->pelanggaran,
      'date' => $get->date,
    ];

    return view('backend.employee.surat_peringatan.view')->with($data);
	}

	public function delete($id)
	{
		$name = auth()->user()->email;
    $menu = "Data Surat Peringatan";

    $get = SuratPeringatan::find($id);

    SuratPeringatan::where('id', $id)->delete();

    $title = $name;
    $action = '<badge class="badge badge-danger">DELETE SURAT PERINGATAN</badge>';
    $keterangan = "Hapus data surat peringatan dari menu <b>" . $menu . "</b> atas nama : <b>" . $get->user->name . "</b>, By : <b>" . $name . "</b>";
    history($title, $action, $keterangan);

    $alert = array(
      'type' => 'info',
      'message' => 'Data berhasil di hapus'
    );

    return redirect()->back()->with($alert);
	}
}
