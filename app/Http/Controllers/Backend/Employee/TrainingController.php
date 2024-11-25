<?php

namespace App\Http\Controllers\Backend\Employee;

use App\Http\Controllers\Controller;
use App\Models\KlasifikasiTraining;
use App\Models\Training;
use App\Models\TrainingLines;
use App\Models\User;
use App\Services\Employee\TrainingServices;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
	public function __construct(TrainingServices $service)
	{
		$this->service = $service;
	}

	public function index()
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

		$row = $this->service->select_index();

		$data = [
      'title' => 'Training & Belting',
			'section' => 'karyawan',
			'sub_section' => 'training',
			'row' => $row,
			'assets' => $assets
    ];

		return view('backend.employee.training.index')->with($data);
	}

	public function search_training(Request $request)
	{
		$klasifikasi = $request->klasifikasi;

    $get = Training::where('klasifikasi_training_id',$klasifikasi)
									 ->orderBy('date','DESC')
									 ->get();

		$list = "<option value=''>-- Pilih Training --</option>";
		foreach ($get as $key) {
			$list .= "<option value='" . $key->id . "'>" . $key->title.', '.$key->date.', '.$key->trainer. "</option>";
		}
		$callback = array('listdoc' => $list);
		echo json_encode($callback);
	}

	public function search(Request $request)
	{
		$post = $request->all();
		$row = $this->service->search($post);

		$data = [
			'row' => $row['row'],
			'header' => $row['header']
		];

		return view('backend.employee.training.view')->with($data);
	}

	public function create(Request $request)
	{
		$row = $this->service->select_create();

		$data = [
      'title' => 'Tambah Data - Training & Belting',
			'row' => $row
    ];

		return view('backend.employee.training.create')->with($data);
	}

	public function store(Request $request)
	{
		$name = auth()->user()->email;
    $menu = "Training & Belting";

    $peserta = $request->peserta;
    $klasifikasi = $request->klasifikasi_training_id;

    if(empty($klasifikasi))
    {
      $klasifikasi_training = 6;
    }
    else
    {
      $klasifikasi_training = $klasifikasi;
    }

    $header = [
      'title' => $request->name,
      'klasifikasi_training_id' => $klasifikasi_training,
      'date' => $request->date,
      'trainer' => $request->trainer
    ];
    
    $post = Training::create($header);

    $lines = [];

    if($post)
    {
      foreach($peserta as $a)
      {
        $user = User::find($a);
        $department_jabatan_id = $user->department_jabatan_id;

        $lines = [
          'training_id' => $post->id,
          'user_id' => $a,
          'lokasi_id' => $user->lokasi_id,
          'department_jabatan_id' => $department_jabatan_id
        ]; 

        TrainingLines::create($lines);
      }
    }

    $alert = array(
      'type' => 'success',
      'message' => 'Data berhasil di diinput'
    );

    $title = $name;
    $action = '<badge class="badge badge-success">INSERT DATA</badge>';
    $keterangan = "Insert data dari menu <b>" . $menu . "</b> tanggal : <b>" . $request->date . "</b> , By : <b>" . $name . "</b>";

    history($title, $action, $keterangan);

    return redirect()->back()->with($alert);
	}

	public function detail(Request $request)
	{
		$id = $request->id;

		$row = $this->service->select_detail($id);

		$data = [
      'title' => 'Detail Data - Training & Belting',
			'data' => $row['data'],
			'belting' => $row['belting']
    ];

		return view('backend.employee.training.detail')->with($data);
	}

	public function update(Request $request, $id)
	{
		$name = auth()->user()->email;
    $menu = "Training & Belting";

    $data = [
      'belting_id' => $request->belting_id,
      'hasil' => $request->hasil,
      'review' => $request->review,
      'note' => $request->note
    ];

    TrainingLines::find($id)->update($data);

    $alert = array(
      'type' => 'info',
      'message' => 'Data berhasil di update'
    );

    $title = $name;
    $action = '<badge class="badge badge-info">UPDATE DATA</badge>';
    $keterangan = "Update data dari menu <b>" . $menu." , By : <b>" . $name . "</b>";

    history($title, $action, $keterangan);

    return redirect()->back()->with($alert);
	}
}
