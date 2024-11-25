<?php

namespace App\Http\Controllers\Backend\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeeSts;
use App\Models\KontrakKerja;
use App\Models\UserLokasi;
use App\Services\Employee\KontrakKerjaServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File as FacadesFile;

class KontrakKerjaController extends Controller
{
	public function __construct(KontrakKerjaServices $service)
	{
		$this->service = $service;
	}

	public function index()
	{
		$assets = [
      'style' => array(
				'assets/backend/libs/select2/css/select2.min.css',
        'assets/js/plugins/air-datepicker/css/datepicker.min.css',
        'assets/backend/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css',
				'assets/backend/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css'
      ),
      'script' => array(
        'assets/backend/libs/datatables.net/js/jquery.dataTables.min.js',
				'assets/backend/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js',
				'assets/backend/libs/select2/js/select2.min.js',
				'assets/js/plugins/air-datepicker/js/datepicker.min.js',
				'assets/js/plugins/air-datepicker/js/i18n/datepicker.en.js'
      )
    ];

		$row = $this->service->data();

		$data = [
      'title' => 'Kontrak Kerja Karyawan',
			'section' => 'karyawan',
			'sub_section' => 'kontrak_kerja',
      'assets' => $assets,
			'row' => $row
    ];

		return view('backend.employee.kontrak_kerja.index')->with($data);
	}

	public function create(Request $request)
	{
		$role = auth()->user()->role_id;
		$users_id = auth()->user()->id;

		$kontrak_sts = EmployeeSts::pluck('title','id');

		if ($role==4 || $role==11) 
		{
			$get_lokasi = UserLokasi::where('users_id', $users_id)->pluck('lokasi_id');
			$user = Employee::where('role_id',5)
											->whereNull('resign_st')
											->whereIn('lokasi_id', $get_lokasi)
											->get();
		}
		else
		{
			$user = Employee::where('role_id',5)
											->whereNull('resign_st')
											->get();
		}

		$data = [
      'employee' => $user,
      'kontrak_sts' => $kontrak_sts
    ];

    return view('backend.employee.kontrak_kerja.create')->with($data);
	}

	public function store(Request $request)
	{
		$data = $request->all();

		$image = $request->file('file');

		$employee = Employee::find($data['user_id']);

		$nik = $employee->nik;

		$input['imagename'] = 'kontrak_kerja_'.$nik.'_'.time().'.'. $image->extension();
		$path = public_path('/storage/upload/employee/' . $nik . '/');
		if (!FacadesFile::isDirectory($path)) {
			FacadesFile::makeDirectory($path);
		}

		$image->move($path, $input['imagename']);
		$origin = $input['imagename'];

		$this->service->store($data, $origin);

		$alert = array(
      'type' => 'info',
      'message' => 'Kontrak kerja berhasil di generate !!!'
    );
    return redirect()->back()->with($alert);
	}

	public function delete($id)
	{
		$get = KontrakKerja::find($id);

		$get_last_non = KontrakKerja::where('user_id',$get->user_id)
																->where('status',0)
																->orderBy('id','DESC')
																->first();

		if(isset($get_last_non))
		{
			$last_id = $get_last_non->id;

			$update_last = ['status'=>1];

			KontrakKerja::find($last_id)->update($update_last);
		}

		KontrakKerja::find($id)->delete();

		$alert = array(
      'type' => 'info',
      'message' => 'Kontrak kerja berhasil di hapus !!!'
    );
    return redirect()->back()->with($alert);
	}
}
