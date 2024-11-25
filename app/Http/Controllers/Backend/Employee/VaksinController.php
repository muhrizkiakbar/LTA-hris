<?php

namespace App\Http\Controllers\Backend\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Vaksin;
use App\Models\VaksinType;
use App\Services\Employee\VaksinServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File as FacadesFile;

class VaksinController extends Controller
{
  public function __construct(VaksinServices $services)
	{
		$this->service = $services;
	}

	public function index(Request $request)
	{
		$id = $request->id;

		$type = VaksinType::orderBy('title','ASC')->pluck('title','id');

		$data = [
			'type' => $type,
			'id' => $id
		];

		return view('backend.employee.detail.vaksin')->with($data);
	}

	public function store(Request $request)
	{
		$name = auth()->user()->email;
    $menu = "Data Vaksin Karyawan";

		// dd($request->all());

    $file = $request->file('file');
    $id = $request->users_id;

		$get = Employee::find($id);
    $nik = $get->nik;


		if (!empty($file)) 
		{
			$input['imagename'] = 'vaksin_'.time() . '.' . $file->extension();
			$path = public_path('/storage/upload/employee/' . $nik . '/');
			if (!FacadesFile::isDirectory($path)) {
				FacadesFile::makeDirectory($path, 0777, true, true);
			}

			$file->move($path, $input['imagename']);
			$origin = $input['imagename'];

			$data = $request->all();
			$data['file'] = $origin;
		}

		Vaksin::create($data);

		$title = $name;
		$action = '<badge class="badge badge-success">UPLOAD DATA VAKSINASI</badge>';
		$keterangan = "Upload data vaksin dari menu <b>" . $menu . "</b>, By : <b>" . $name . "</b>";

		history($title, $action, $keterangan);

		$alert = array(
			'type' => 'info',
			'message' => 'Data berhasil di input'
		);
		
    return redirect()->route('backend.employee.detail', $id)->with($alert);
	}

	public function view(Request $request)
	{
		$get = Vaksin::find($request->id);

		$data = [
			'title' => 'Data Vaksin',
			'file_type' => 'pdf',
			'file' => $get->file,
			'nik' => $get->employee->nik
		];

		return view('backend.employee.detail.document_view')->with($data);
	}

	public function delete($id)
	{
		$name = auth()->user()->email;
    $menu = "Data Karyawan";

    $get = Vaksin::find($id);

    Vaksin::where('id', $id)->delete();

    $title = $name;
    $action = '<badge class="badge badge-danger">DELETE KARTU VAKSINASI</badge>';
    $keterangan = "Hapus data kartu vaksinasi dari menu <b>" . $menu . "</b> atas nama : <b>" . $get->employee->name . "</b>, By : <b>" . $name . "</b>";
    history($title, $action, $keterangan);

    $alert = array(
      'type' => 'info',
      'message' => 'Data berhasil di hapus'
    );

    return redirect()->back()->with($alert);
	}
}
