<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use App\Models\User;
use App\Models\UserLokasi;
use App\Models\UsersRole;
use App\Services\UserServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
	public function __construct(UserServices $services)
	{
		$this->service = $services;
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
      'title' => 'Users Management',
			'section' => 'dashboard', 
      'assets' => $assets,
			'row' => $row
    ];

		return view('backend.users.index')->with($data);
	}

	public function create(Request $request)
	{
		$role = UsersRole::pluck('title', 'id');
    $lokasi = Lokasi::pluck('title', 'id');

		$data = [
			'title' => 'Tambah Data - Users Management',
      'role' => $role,
      'lokasi' => $lokasi
    ];

		return view('backend.users.create')->with($data);
	}

	public function store(Request $request)
	{
		$this->service->store($request->all());

		$alert = array(
      'type' => 'success',
      'message' => 'Data berhasil di input'
    );

		return redirect()->back()->with($alert);
	}

	public function edit(Request $request)
	{
		$id = $request->id;

		$role = UsersRole::pluck('title', 'id');

		$row = User::find($id);

		$data = [
			'title' => 'Update Data - Users Management',
      'role' => $role,
			'row' => $row
    ];

		return view('backend.users.edit')->with($data);
	}

	public function update(Request $request, $id)
	{
		$data = $request->all();

		User::find($id)->update($data);

		$alert = array(
      'type' => 'success',
      'message' => 'Data berhasil di update !'
    );

		return redirect()->back()->with($alert);
	}

	public function lokasi(Request $request)
	{
		$id = $request->id;

		$lokasi = Lokasi::pluck('title', 'id');

		$row = UserLokasi::where('users_id',$id)->get();

		$data = [
			'title' => 'Update Lokasi - Users Management',
      'lokasi' => $lokasi,
			'id' => $id,
			'row' => $row
    ]; 

		return view('backend.users.lokasi')->with($data);
	}

	public function lokasi_update(Request $request)
	{
		$cek = UserLokasi::where('users_id',$request->users_id)
										 ->where('lokasi_id',$request->lokasi_id)
										 ->get();

		if (count($cek) > 0) 
		{
			$alert = array(
				'type' => 'danger',
				'message' => 'Data users lokasi telah di inputkan !'
			);
		}
		else
		{
			$data = [
				'users_id' => $request->users_id,
				'lokasi_id' => $request->lokasi_id
			];
	
			UserLokasi::create($data);

			$alert = array(
				'type' => 'success',
				'message' => 'Data users lokasi berhasil di update !'
			);
		}
		
		return redirect()->back()->with($alert);
	}

	public function lokasi_delete($id)
	{
		UserLokasi::find($id)->delete();

		$alert = array(
			'type' => 'success',
			'message' => 'Data users lokasi berhasil di hapus !'
		);

		return redirect()->back()->with($alert);
	}

	public function password(Request $request)
	{
		$id = $request->id;

		$data = [
			'title' => 'Update Password - Users Management',
			'id' => $id,
    ]; 

		return view('backend.users.password')->with($data);
	}

	public function password_update(Request $request)
	{
		$data = [
			'password' => Hash::make($request->password)
		];

		User::find($request->users_id)->update($data);

		$alert = array(
			'type' => 'success',
			'message' => 'Data users password berhasil di update !'
		);

		return redirect()->back()->with($alert);
	}
}
