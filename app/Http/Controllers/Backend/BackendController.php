<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\DepartmentJabatan;
use App\Models\PayrollConfig;
use App\Models\User;
use App\Models\UserLokasi;
use App\Models\WhatsappMonitor;
use App\Services\BackendServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BackendController extends Controller
{
  public function __construct(BackendServices $service)
	{
		$this->service = $service;
	}

	public function index()
  {
		$role = auth()->user()->role_id;

		$kontrak = $this->service->expired_kontrak();
		$group_kontrak = $this->service->group_kontrak();
		$group_kontrak_sum = array_sum(array_column($group_kontrak,'total'));

		$karyawan_gender = $this->service->karyawan_gender();
		$karyawan_gender_sum = array_sum(array_column($karyawan_gender,'total'));

		$assets = [
			'style' => array(
				'assets/backend/libs/apexcharts/apexcharts.css',
				'assets/backend/libs/chart.js/Chart.min.css'
      ),
      'script' => array(
        'assets/backend/libs/apexcharts/apexcharts.min.js',
				'assets/backend/libs/chart.js/Chart.min.js'
      )
    ];

		
		if (auth()->user()->department_id==1 && auth()->user()->jabatan_id == 3) 
		{
			$view = 'backend.dashboard.finance';
		}
		else
		{
			$view = 'backend.dashboard.hrd';
		}

		$payroll_config = PayrollConfig::find(1);

    $data = [
      'title' => 'Dashboard',
			'section' => 'dashboard',
			'assets' => $assets,
			'kontrak' => $kontrak,
			'group_kontrak' => $group_kontrak,
			'group_kontrak_sum' => $group_kontrak_sum,
			'karyawan_gender' => $karyawan_gender,
			'karyawan_gender_sum' => $karyawan_gender_sum,
			'view' => $view,
			'payroll_config' => $payroll_config
    ];

    return view('backend.index')->with($data);
  }

	public function dashboard()
	{
		$data = [
      'title' => 'Dashboard',
			'section' => 'dashboard'
    ];

    return view('dashboard.index')->with($data);
	}

	public function password()
	{
		$users_id = auth()->user()->id;

		$data = [
      'title' => 'Ubah Password',
			'users_id' => $users_id
    ];

    return view('backend.change_password')->with($data);
	}

	public function password_update(Request $request)
	{
		$data = [
			'password' => Hash::make($request->password)
		];

		User::find($request->users_id)->update($data);

		$alert = array(
			'type' => 'success',
			'message' => 'Ubah password berhasil di lakukan !!!'
		);

		return redirect()->back()->with($alert);
	}

  public function logout()
  {
    auth()->guard('web')->logout(); //JADI KITA LOGOUT SESSION DARI GUARD CUSTOMER
    return redirect(route('login'));
  }

  public function get_department_jabatan(Request $request)
  {
    $department = $request->department;
    $jabatan = $request->jabatan;

    $get = DepartmentJabatan::where('department_id',$department)
														->where('jabatan_id',$jabatan)
														->get();

		$list = "<option value=''>-- Jabatan --</option>";
		foreach ($get as $key) {
			$list .= "<option value='" . $key->id . "'>" . $key->title . "</option>";
		}
		$callback = array('listdoc' => $list);
		echo json_encode($callback);
  }

	public function get_jabatan_exist(Request $request)
	{
		$id = $request->employee_id;

		$user = User::find($id);

		$get = DepartmentJabatan::where('department_id',$user->department_id)
														->where('jabatan_id',$user->jabatan_id)
														->get();

		$list = "<option value=''>-- Jabatan --</option>";
		foreach ($get as $key) {
			if ($key->id==$user->department_jabatan_id) 
			{
				$select = "selected";
			}
			else
			{
				$select = "";
			}

			$list .= "<option value='" . $key->id ."'".$select.">" . $key->title . "</option>";
		}
		$callback = array('listdoc' => $list);
		echo json_encode($callback);
	}

	public function get_employee_exchange(Request $request)
	{
		$id = $request->employee_id;

		$user = User::find($id);

		$distrik = $user->distrik_id;

		if ($distrik==7) 
		{
			$get = User::where('id','!=',$id)
								->where('role_id',5)
								->whereNull('resign_st')
								->get();
		}
		else
		{
			$get = User::where('department_id',$user->department_id)
								->where('id','!=',$id)
								->where('role_id',5)
								->whereNull('resign_st')
								->get();
		}

		$list = "<option value=''>-- Karyawan --</option>";
		foreach ($get as $key) 
		{
			$list .= "<option value='" . $key->id ."'>".$key->nik." - ".$key->name."</option>";
		}
		$callback = array('listdoc' => $list);
		echo json_encode($callback);
	}

	public function whatsapp()
	{
		$role = auth()->user()->role_id;
    $users_id = auth()->user()->id;

		$assets = [
      'style' => array(
        'assets/backend/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css',
				'assets/backend/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css'
      ),
      'script' => array(
        'assets/backend/libs/datatables.net/js/jquery.dataTables.min.js',
				'assets/backend/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js'
      )
    ];

		if ($role==4) 
		{
			$get_lokasi = UserLokasi::where('users_id', $users_id)->pluck('lokasi_id');
			$row = WhatsappMonitor::whereIn('lokasi_id',$get_lokasi)
														->orderBy('date','DESC')
														->get();
		}
		else
		{
			$row = WhatsappMonitor::orderBy('date','DESC')
														->get();
		}

		$data = [
      'title' => 'Whatsapp Monitor',
			'section' => 'dashboard',
      'assets' => $assets,
			'row' => $row
    ];

		return view('backend.whatsapp')->with($data);
	}

	public function whatsapp_resend($id)
	{
		$get = WhatsappMonitor::find($id);

		$url = explode('/',$get->teks);

		$code = $url[5];

		if ($code=='ijin' || $code=='tahunan' || $code=='khusus') 
		{
			$codex = $url[6];

			$url_decode = base64_decode($codex);
			$exp = explode('&',$url_decode);

			$otp = $exp[2];
		}
		else
		{
			$url_decode = base64_decode($code);
			$exp = explode('&',$url_decode);

			$otp = $exp[2];
		}
		
		$data = [
			'no_wa' => $get->no_wa,
			'teks_tengah' => $get->teks,
			'subject' => $get->subject,
			'new_message' => $get->message,
			'teks_otp' => 'Kode OTP : *'.$otp.'*'
		];

		$this->service->resend_wa($data);

		$alert = array(
			'type' => 'success',
			'message' => 'Data berhasil di kirim ulang'
		);

		return redirect()->back()->with($alert);	
	}

	public function activity_user()
	{
		$assets = [
      'style' => array(
        'assets/backend/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css',
				'assets/backend/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css'
      ),
      'script' => array(
				'assets/js/plugins/ace/ace.js',
        'assets/backend/libs/datatables.net/js/jquery.dataTables.min.js',
				'assets/backend/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js'
      )
    ];

		$row = ActivityLog::orderBy('id','DESC')->get();

		$data = [
      'title' => 'Activity Log User',
			'section' => 'dashboard',
      'assets' => $assets,
			'row' => $row
    ];

		return view('backend.activity_user')->with($data);
	}
}
