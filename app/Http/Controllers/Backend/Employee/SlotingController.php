<?php

namespace App\Http\Controllers\Backend\Employee;

use App\Http\Controllers\Controller;
use App\Models\Cabang;
use App\Models\Department;
use App\Models\DepartmentJabatan;
use App\Models\Divisi;
use App\Models\Jabatan;
use App\Models\Lokasi;
use App\Models\Sloting;
use App\Models\User;
use App\Models\UserLokasi;
use App\Services\Employee\SlotingServices;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;

class SlotingController extends Controller
{
	public function __construct(SlotingServices $service)
	{
		$this->service = $service;
	}
	
	public function index()
	{
		$assets = [
      'style' => array(
        'assets/css/loading.css',
				'assets/backend/libs/select2/css/select2.min.css',
				'assets/js/plugins/sweetalert2/sweetalert2.min.css'
      ),
      'script' => array(
        'assets/js/plugins/sweetalert2/sweetalert2.min.js',
				'assets/backend/libs/select2/js/select2.min.js',
      )
    ];

		$row = $this->service->select_index();

		$data = [
      'title' => 'Sloting Karyawan',
			'section' => 'karyawan',
			'sub_section' => 'sloting',
			'department' => $row['department'],
			'cabang' => $row['cabang'],
			'assets' => $assets
    ];

		return view('backend.employee.sloting.index')->with($data);
	}

	public function create(Request $request)
	{
		$row = $this->service->select_create();

		$data = [
      'title' => 'Tambah Data - Sloting Karyawan',
			'department' => $row['department'],
			'cabang' => $row['cabang'],
			'jabatan' => $row['jabatan'],
			'divisi' => $row['divisi'],
    ];

		return view('backend.employee.sloting.create')->with($data);
	}

	public function store(Request $request)
	{
		// dd($request->all());

		$employee = $request->users_id;
    $department = $request->department_id;
    $jabatan = $request->jabatan_id;
		$department_jabatan = $request->department_jabatan_id;
    $cabang = $request->cabang_id;
    $principle = $request->divisi_id;

		$sloting = generate_sloting($department,$department_jabatan,$cabang,$principle);

		$data = [
			'kd' => $sloting,
			'department_id' => $department,
			'jabatan_id' => $jabatan,
			'department_jabatan_id' => $department_jabatan,
			'cabang_id' => $cabang,
			'divisi_id' => $principle,
			'users_id' => $employee
		];

		// dd($data);

		Sloting::create($data);

		$alert = array(
      'type' => 'success',
      'message' => 'Data berhasil di input'
    );

    return redirect()->back()->with($alert);
	}
	
	public function search(Request $request)
	{
		$department = $request->department;
		$cabang = $request->cabang;

		$row = $this->service->search($department, $cabang);

		$data = [
			'row' => $row
		];

		return view('backend.employee.sloting.view')->with($data);
	}

	public function edit(Request $request)
	{
		$id = $request->id;

		$row = Sloting::find($id);

		$user = User::where('department_id',$row->department_id)
								->where('lokasi_id',$row->cabang_id)
								->where('resign_st',NULL)
								->pluck('name','id');

		$data = [
			'title' => 'Update - Sloting Karyawan',
			'row' => $row,
			'user' => $user
		];

		return view('backend.employee.sloting.update')->with($data);
	}

	public function update(Request $request, $id)
	{
		$post = [
			'users_id' => $request->users_id
		];

		Sloting::find($id)->update($post);

		$alert = array(
      'type' => 'info',
      'message' => 'Data berhasil di update'
    );

    return redirect()->back()->with($alert);
	}

	public function delete(Request $request)
	{
		$get = Sloting::find($request->id);

		$callback = [
			'department' => $get->department_id,
			'cabang' => $get->cabang_id
		];

		Sloting::find($request->id)->delete();

		echo json_encode($callback);
	}

	public function generate_jabatan_id()
	{
		$get = Sloting::get();

		foreach ($get as $value) 
		{
			$get_jabatan = DepartmentJabatan::where('department_id',$value->department_id)
																			->where('id',$value->department_jabatan_id)
																			->first();
			if (isset($get_jabatan)) 
			{
				$data = [
					'jabatan_id' => $get_jabatan->jabatan_id
				];
	
				Sloting::find($value->id)->update($data);
			}
			else
			{
				Sloting::find($value->id)->delete();
			}
		}
	}

	public function employee_cabang(Request $request)
	{
		$department = $request->department;
    $jabatan = $request->jabatan;
		$department_jabatan = $request->department_jabatan;
		$cabang = Cabang::find($request->cabang);
		$divisi = $request->divisi;

		// dd($cabang->lokasi_id);
		$cek_user = Sloting::where('department_id',$department)
											 ->where('department_jabatan_id',$department_jabatan)
											 ->where('cabang_id',$request->cabang)
											 ->where('divisi_id',$divisi)
											 ->pluck('users_id');

    $get = User::where('department_id',$department)
							 ->where('lokasi_id',$request->cabang)
							 ->where('resign_st',NULL)
							 ->whereNotIn('id',$cek_user)
							 ->get();

		$list = "<option value=''>-- Pilih Karyawan --</option>";
		foreach ($get as $key) 
		{
			$list .= "<option value='" . $key->id . "'>" . $key->name . "</option>";
		}
		$callback = array('listdoc' => $list);
		echo json_encode($callback);
	}
}
