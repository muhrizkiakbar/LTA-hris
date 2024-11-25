<?php

namespace App\Http\Controllers\Backend\Employee;

use App\Http\Controllers\Controller;
use App\Models\AbsensiIjinLines;
use App\Models\Bank;
use App\Models\Blood;
use App\Models\ClaimPrincipal;
use App\Models\Country;
use App\Models\CutiLines;
use App\Models\Department;
use App\Models\Distrik;
use App\Models\Divisi;
use App\Models\Employee;
use App\Models\Gender;
use App\Models\Ijazah;
use App\Models\Jabatan;
use App\Models\Lokasi;
use App\Models\Marriage;
use App\Models\Perusahaan;
use App\Models\Ptkp;
use App\Models\Religion;
use App\Models\User;
use App\Models\UserLokasi;
use App\Models\VaksinType;
use App\Services\Employee\EmployeeServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File as FacadesFile;
use OpenSpout\Common\Entity\Style\CellAlignment;
use OpenSpout\Common\Entity\Style\Style;
use Rap2hpoutre\FastExcel\FastExcel;

class EmployeeController extends Controller
{
	public function __construct(EmployeeServices $service)
	{
		$this->service = $service;
	}

	public function index()
	{
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

		$row = $this->service->getData();

		$data = [
      'title' => 'Data Karyawan',
			'section' => 'karyawan',
			'sub_section' => 'data_karyawan',
      'assets' => $assets,
			'row' => $row
    ];

		return view('backend.employee.index')->with($data);
	}

	public function create()
	{
		$role = auth()->user()->role_id;
    $users_id = auth()->user()->id;

		$assets = [
      'style' => array(
				'assets/backend/libs/select2/css/select2.min.css',
        'assets/js/plugins/air-datepicker/css/datepicker.min.css'
      ),
      'script' => array(
        'assets/js/plugins/notifications/sweet_alert.min.js',
        'assets/backend/libs/select2/js/select2.min.js',
				'assets/js/plugins/air-datepicker/js/datepicker.min.js',
				'assets/js/plugins/air-datepicker/js/i18n/datepicker.en.js'
      )
    ];

		$gender = Gender::pluck('title', 'id');
    $religion = Religion::pluck('title', 'id');
    $country = Country::pluck('title', 'id');
    $blood = Blood::pluck('title', 'id');
    $marriage = Marriage::pluck('title', 'id');
    $ptkp = Ptkp::pluck('title', 'id');
    $atasan = Employee::whereIn('role_id', [2,5])
                  ->whereNull('resign_st')
                  ->orderBy('role_id','ASC')
                  ->pluck('name', 'id');
    $department = Department::pluck('title', 'id');
    $divisi = Divisi::pluck('title', 'id');
    $jabatan = Jabatan::pluck('title', 'id');
    $bank = Bank::pluck('title','id');
    $distrik = Distrik::pluck('title','id');
    $perusahaan = Perusahaan::pluck('title','id');

    if ($role == 1) {
      $lokasi = Lokasi::pluck('title', 'id');
    } else {
      $lokasi = UserLokasi::where('users_id', $users_id)->get();
    }

		$claim_principal = ClaimPrincipal::pluck('title','id');

		$data = [
      'title' => 'Tambah Data Karyawan',
			'section' => 'karyawan',
			'sub_section' => 'data_karyawan',
      'assets' => $assets,
      'gender' => $gender,
      'religion' => $religion,
      'country' => $country,
      'blood' => $blood,
      'marriage' => $marriage,
      'lokasi' => $lokasi,
      'ptkp' => $ptkp,
      'role' => $role,
      'department' => $department,
      'divisi' => $divisi,
      'jabatan' => $jabatan,
      'atasan' => $atasan,
      'bank' => $bank,
      'distrik' => $distrik,
      'perusahaan' => $perusahaan,
			'claim_principal' => $claim_principal
    ];

		return view('backend.employee.create.index')->with($data);
	}

	public function store(Request $request)
	{
		// dd($request->all());

		$name = auth()->user()->email;
    $menu = "Data Karyawan";

    $image = $request->file('foto');
    $nik = generate_nik($request->join_date, $request->lokasi_id);

		$ktp_no = $request->ktp_no;

		$cek_ktp = Employee::where('ktp_no',$ktp_no)->first();

		if (isset($cek_ktp)) 
		{
			if ($cek_ktp->resign_types_id=='2' || $cek_ktp->resign_types_id=='3') 
			{
				$alert = array(
					'type' => 'danger',
					'message' => 'Maaf, KTP telah di Black List dikarenakan FRAUD !'
				);

				return redirect()->back()->with($alert);
			}
		}
		else
		{
			if (empty($image)) 
			{
				$data = $request->all();
				$data['nik'] = $nik;
				$data['password'] = Hash::make($nik);
				$data['role_id'] = 5;
			} 
			else 
			{
				$input['imagename'] = time() . '.' . $image->extension();
				$path = public_path('/storage/upload/employee/' . $nik . '/');
				if (!FacadesFile::isDirectory($path)) {
					FacadesFile::makeDirectory($path, 0777, true, true);
				}

				$image->move($path, $input['imagename']);
				$origin = $input['imagename'];

				$data = $request->all();
				$data['nik'] = $nik;
				$data['password'] = Hash::make($nik);
				$data['foto'] = $origin;
				$data['role_id'] = 5;
			}

			Employee::create($data);

			$title = $name;
			$action = '<badge class="badge badge-success">INSERT DATA</badge>';
			$keterangan = "Input data baru dari menu <b>" . $menu . "</b> dengan title : <b>" . $request->name . "</b> , By : <b>" . $name . "</b>";

			history($title, $action, $keterangan);

			$alert = array(
				'type' => 'info',
				'message' => 'Data berhasil di input'
			);

			return redirect()->route('backend.employee')->with($alert);
		}

    
	}

	public function detail($id)
	{
		$row = $this->service->detail($id);

		$role = auth()->user()->role_id;

		$assets = [
      'style' => array(
				'assets/backend/libs/select2/css/select2.min.css',
        'assets/js/plugins/air-datepicker/css/datepicker.min.css'
      ),
      'script' => array(
        'assets/backend/libs/select2/js/select2.min.js',
				'assets/js/plugins/air-datepicker/js/datepicker.min.js',
				'assets/js/plugins/air-datepicker/js/i18n/datepicker.en.js'
      )
    ];

		$data = [
			'id' => $id,
      'title' => 'Detail - Data Karyawan',
			'section' => 'karyawan',
			'sub_section' => 'data_karyawan', 
			'row' => $row['get'],
			'saldo_cuti' => $row['saldo_cuti'],
			'vaksin' => $row['vaksin'],
			'konseling' => $row['konseling'],
			'surat_peringatan' => $row['surat_peringatan'],
			'appraisal' => $row['appraisal'],
			'absensi_yearly' => $row['absensi_yearly'],
			'assets' => $assets,
			'role' => $role
    ];

    return view('backend.employee.detail.index')->with($data);
	}

	public function edit(Request $request)
	{
		$role = auth()->user()->role_id;
		$users_id = auth()->user()->id;

		$gender = Gender::pluck('title', 'id');
    $religion = Religion::pluck('title', 'id');
    $country = Country::pluck('title', 'id');
    $blood = Blood::pluck('title', 'id');
    $marriage = Marriage::pluck('title', 'id');
    $ptkp = Ptkp::pluck('title', 'id');
    $atasan = Employee::whereIn('role_id', [2,5])
                  ->whereNull('resign_st')
                  ->orderBy('role_id','ASC')
                  ->pluck('name', 'id');
    $department = Department::pluck('title', 'id');
    $divisi = Divisi::pluck('title', 'id');
    $jabatan = Jabatan::pluck('title', 'id');
    $bank = Bank::pluck('title','id');
    $distrik = Distrik::pluck('title','id');
    $perusahaan = Perusahaan::pluck('title','id');

    if ($role == 1) {
      $lokasi = Lokasi::pluck('title', 'id');
    } else {
      $user_lokasi = UserLokasi::where('users_id', $users_id)->pluck('lokasi_id');
			$lokasi = Lokasi::whereIn('id',$user_lokasi)->pluck('title', 'id');
    }

		$claim_principal = ClaimPrincipal::pluck('title','id');

		$row = Employee::find($request->id);

		$data = [
      'gender' => $gender,
      'religion' => $religion,
      'country' => $country,
      'blood' => $blood,
      'marriage' => $marriage,
      'lokasi' => $lokasi,
      'ptkp' => $ptkp,
      'department' => $department,
      'divisi' => $divisi,
      'jabatan' => $jabatan,
      'atasan' => $atasan,
      'bank' => $bank,
      'distrik' => $distrik,
      'perusahaan' => $perusahaan,
			'row' => $row,
			'role' => $role,
			'claim_principal' => $claim_principal
    ];

		return view('backend.employee.detail.edit')->with($data);
	}

	public function update(Request $request, $id)
	{
		$name = auth()->user()->email;
    $menu = "Data Karyawan";

		$employee = Employee::find($id);
		$nik = $employee->nik;

		$image = $request->file('foto');

		if (empty($image)) 
		{
			$data = $request->all();
      Employee::find($id)->update($data);
		}
		else
		{
			$input['imagename'] = 'pic_' . time() . '.' . $image->extension();
      $path = public_path('/storage/upload/employee/' . $nik . '/');
      if (!FacadesFile::isDirectory($path)) {
        FacadesFile::makeDirectory($path);
      }
      $image->move($path, $input['imagename']);
      $origin = $input['imagename'];
      
      $data = $request->all();
      $data['foto'] = $origin;

      Employee::find($id)->update($data);
		}

		$title = $name;
		$action = '<badge class="badge badge-info">UPDATE DATA</badge>';
		$keterangan = "Edit data dari menu <b>" . $menu . "</b> dengan title : <b>" . $request->name . "</b> , By : <b>" . $name . "</b>";

		history($title, $action, $keterangan);

		$alert = array(
			'type' => 'info',
			'message' => 'Data berhasil di update'
		);
		return redirect()->back()->with($alert);
	}

	public function detail_cuti(Request $request)
	{
		$id = $request->id;
    $get = Employee::find($id);
    $join_date = $get->join_date;

		$explode = explode("-", $join_date);
    $bln = $explode[1];
    $tgl = $explode[2];
    $tglg = date('Y-' . $bln . "-" . $tgl);

		if (strtotime($tglg) > strtotime(date("Ymd"))) {
      $tglg = date("Y-m-d", strtotime($tglg . "-1 year"));
    }

		$tgl2 = date('Y-m-d', strtotime('+1 year', strtotime($tglg)));
    $tgl_now = date('Y-m-d');

		$cuti_bersama = CutiLines::where('date', '>=', $tglg)
														 ->where('date', '<=', $tgl_now)
														 ->where('cuti_type_id', 5)
														 ->orderBy('date', 'ASC')
														 ->get();

    $cuti_pribadi = CutiLines::where('employee_id', $id)
														 ->where('date', '>=', $tglg)
														 ->where('date', '<=', $tgl2)
														 ->where('approval_st', 1)
														 ->where('cuti_type_id', 1)
														 ->get();

    $ijin = AbsensiIjinLines::where('users_id', $id)
														->where('date', '>=', $tglg)
														->where('date', '<=', $tgl2)
														->where('absensi_ijin_type_id', 2)
														->where('status', 1)
														->get();

		$data = [
			'hak_cuti' => get_hak_cuti($id, $join_date, "now"),
      'sisa_cuti' => get_saldo_cuti($id, $join_date, "now"),
			'sisa_cuti_kemaren' => get_saldo_cuti($id, $join_date, "kemarin"),
			'periode_start' => tgl_indo($tglg),
			'periode_end' => tgl_indo($tgl2),
			'cuti_bersama' => $cuti_bersama,
			'cuti_pribadi' => $cuti_pribadi,
			'ijin' => $ijin
		];

		return view('backend.employee.detail.detail_cuti')->with($data);
	}

	public function reset_password($id)
	{
		$this->service->reset_password($id);

		$alert = array(
			'type' => 'info',
			'message' => 'Data berhasil di update password'
		);
		return redirect()->back()->with($alert);
	}

	public function sign(Request $request)
	{
		$id = $request->id;

    $get = Employee::find($id);
    $ttd_url = $get->sign_pic;

    $data = [
      'get' => $get,
      'ttd_url' => $ttd_url
    ];
    return view('backend.employee.detail.upload_sign')->with($data);
	}

	public function sign_update(Request $request)
	{
		$name = auth()->user()->email;
    $menu = "Data Karyawan";

		$id = $request->id;

    $get = Employee::find($id);
    $nik = $get->nik;
    $nama = $get->name;

    $image = $request->file('sign_file');

    if (!empty($image)) {
      $input['imagename'] = 'sign_' . time() . '.' . $image->extension();
      $path = public_path('/storage/upload/employee/' . $nik . '/');
      if (!FacadesFile::isDirectory($path)) {
        FacadesFile::makeDirectory($path);
      }
      $image->move($path, $input['imagename']);
      $origin = $input['imagename'];

      $data = [
        'sign_file' => $origin
      ];

      Employee::find($id)->update($data);
    }

    $title = $name;
    $action = '<badge class="badge badge-info">UPDATE DATA</badge>';
    $keterangan = "Update data tanda tangan dari menu <b>" . $menu . "</b> dengan title : <b>" . $nama . "</b> , By : <b>" . $name . "</b>";

    history($title, $action, $keterangan);

    $alert = array(
      'type' => 'info',
      'message' => 'Data berhasil di update'
    );
    return redirect()->back()->with($alert);
	}

	public function ktp(Request $request)
	{
		$id = $request->id;

    $get = Employee::find($id);

    $data = [
      'get' => $get
    ];
    return view('backend.employee.detail.upload_ktp')->with($data);
	}

	public function ktp_update(Request $request, $id)
	{
		$name = auth()->user()->email;
    $menu = "Data Karyawan";

    $get = Employee::find($id);
    $nik = $get->nik;
    $nama = $get->name;
		$file = $get->ktp;

    $image = $request->file('ktp');

    if (!empty($image)) 
		{
			if(isset($file))
			{
				removeFile($nik, $file);
			}
			
      $input['imagename'] = 'KTP_'.$nik.'_'.time().'.'. $image->extension();
      $path = public_path('/storage/upload/employee/' . $nik . '/');
      if (!FacadesFile::isDirectory($path)) {
        FacadesFile::makeDirectory($path);
      }
      $image->move($path, $input['imagename']);
      $origin = $input['imagename'];

      $data = [
        'ktp' => $origin,
        'ktp_no' => $request->ktp_no
      ];

      Employee::find($id)->update($data);
    }

    $title = $name;
    $action = '<badge class="badge badge-info">UPDATE DATA</badge>';
    $keterangan = "Update data KTP dari menu <b>" . $menu . "</b> dengan title : <b>" . $nama . "</b> , By : <b>" . $name . "</b>";

    history($title, $action, $keterangan);

    $alert = array(
      'type' => 'info',
      'message' => 'Data berhasil di update'
    );

    return redirect()->back()->with($alert);
	}

	public function ktp_view(Request $request)
	{
		$get = Employee::find($request->id);

		$file = $get->ktp;

		$exp = explode('.',$file);

		$data = [
			'title' => 'File KTP - '.$get->name,
			'file_type' => $exp[1],
			'file' => $file,
			'nik' => $get->nik
		];

		return view('backend.employee.detail.document_view')->with($data);
	}

	public function ktp_delete($id)
	{
		$name = auth()->user()->email;
    $menu = "Data Karyawan";

    $get = Employee::find($id);
    $nik = $get->nik;
    $nama = $get->name;
		$file = $get->kk;

		if(isset($file))
		{
			removeFile($nik, $file);
		}

		$data = [
			'ktp' => NULL,
			'ktp_no' => NULL
		];

		Employee::find($id)->update($data);

    $title = $name;
    $action = '<badge class="badge badge-danger">DELETE DATA</badge>';
    $keterangan = "Delete data KTP dari menu <b>" . $menu . "</b> dengan title : <b>" . $nama . "</b> , By : <b>" . $name . "</b>";

    history($title, $action, $keterangan);

    $alert = array(
      'type' => 'info',
      'message' => 'Data berhasil di hapus'
    );

    return redirect()->back()->with($alert);
	}

	public function kartu_keluarga(Request $request)
	{
		$id = $request->id;

    $get = Employee::find($id);

    $data = [
      'get' => $get
    ];
    return view('backend.employee.detail.upload_kk')->with($data);
	}

	public function kartu_keluarga_update(Request $request, $id)
	{
		$name = auth()->user()->email;
    $menu = "Data Karyawan";

    $get = Employee::find($id);
    $nik = $get->nik;
    $nama = $get->name;
		$file = $get->kk;

    $image = $request->file('file');

    
		if(isset($file))
		{
			removeFile($nik, $file);
		}

		$input['imagename'] = 'KK_'.$nik.'_'.time().'.'. $image->extension();
		$path = public_path('/storage/upload/employee/' . $nik . '/');
		if (!FacadesFile::isDirectory($path)) {
			FacadesFile::makeDirectory($path);
		}
		$image->move($path, $input['imagename']);
		$origin = $input['imagename'];

		$data = [
			'kk' => $origin,
		];

		Employee::find($id)->update($data);
    

    $title = $name;
    $action = '<badge class="badge badge-info">UPDATE DATA</badge>';
    $keterangan = "Update data Kartu Keluarga dari menu <b>" . $menu . "</b> dengan title : <b>" . $nama . "</b> , By : <b>" . $name . "</b>";

    history($title, $action, $keterangan);

    $alert = array(
      'type' => 'info',
      'message' => 'Data berhasil di update'
    );

    return redirect()->back()->with($alert);
	}

	public function kartu_keluarga_view(Request $request)
	{
		$get = Employee::find($request->id);

		$file = $get->kk;

		$exp = explode('.',$file);

		$data = [
			'title' => 'File Kartu Keluarga - '.$get->name,
			'file_type' => $exp[1],
			'file' => $file,
			'nik' => $get->nik
		];

		return view('backend.employee.detail.document_view')->with($data);
	}

	public function kartu_keluarga_delete($id)
	{
		$name = auth()->user()->email;
    $menu = "Data Karyawan";

    $get = Employee::find($id);
    $nik = $get->nik;
    $nama = $get->name;
		$file = $get->kk;

    
		if(isset($file))
		{
			removeFile($nik, $file);
		}

		$data = [
			'kk' => NULL,
		];

		Employee::find($id)->update($data);
    

    $title = $name;
    $action = '<badge class="badge badge-danger">DELETE DATA</badge>';
    $keterangan = "Delete data Kartu Keluarga dari menu <b>" . $menu . "</b> dengan title : <b>" . $nama . "</b> , By : <b>" . $name . "</b>";

    history($title, $action, $keterangan);

    $alert = array(
      'type' => 'info',
      'message' => 'Data berhasil di hapus'
    );

    return redirect()->back()->with($alert);
	}

	public function ijazah(Request $request)
	{
		$id = $request->id;

    $get = Employee::find($id);
		$ijazah = Ijazah::orderBy('urutan','ASC')->pluck('title', 'id');

    $data = [
      'get' => $get,
			'ijazah' => $ijazah
    ];
    return view('backend.employee.detail.upload_ijazah')->with($data);
	}

	public function ijazah_update(Request $request, $id)
	{
		$name = auth()->user()->email;
    $menu = "Data Karyawan";

    $get = Employee::find($id);
    $nik = $get->nik;
    $nama = $get->name;
		$file = $get->ijazah;

    $image = $request->file('file');

    if (!empty($image)) 
		{
			if(isset($file))
			{
				removeFile($nik, $file);
			}

      $input['imagename'] = 'Ijazah_'.$nik.'_'.time().'.'. $image->extension();
      $path = public_path('/storage/upload/employee/' . $nik . '/');
      if (!FacadesFile::isDirectory($path)) {
        FacadesFile::makeDirectory($path);
      }
      $image->move($path, $input['imagename']);
      $origin = $input['imagename'];

      $data = [
        'ijazah' => $origin,
        'ijazah_id' => $request->ijazah_id,
        'ijazah_institusi' => $request->ijazah_institusi,
        'ijazah_jurusan' => $request->ijazah_jurusan
      ];

      Employee::find($id)->update($data);
    }

    $title = $name;
    $action = '<badge class="badge badge-info">UPDATE DATA</badge>';
    $keterangan = "Update data ijazah dari menu <b>" . $menu . "</b> dengan title : <b>" . $nama . "</b> , By : <b>" . $name . "</b>";

    history($title, $action, $keterangan);

    $alert = array(
      'type' => 'info',
      'message' => 'Data berhasil di update'
    );

    return redirect()->back()->with($alert);
	}

	public function ijazah_view(Request $request)
	{
		$get = Employee::find($request->id);

		$file = $get->ijazah;

		$exp = explode('.',$file);

		$data = [
			'title' => 'File Ijazah - '.$get->name,
			'file_type' => $exp[1],
			'file' => $file,
			'nik' => $get->nik
		];

		return view('backend.employee.detail.document_view')->with($data);
	}

	public function ijazah_delete($id)
	{
		$name = auth()->user()->email;
    $menu = "Data Karyawan";

    $get = Employee::find($id);
    $nik = $get->nik;
    $nama = $get->name;
		$file = $get->kk;

		if(isset($file))
		{
			removeFile($nik, $file);
		}

		$data = [
			'ijazah' => NULL,
			'ijazah_id' => NULL,
			'ijazah_institusi' => NULL,
			'ijazah_jurusan' => NULL
		];

		Employee::find($id)->update($data);

    $title = $name;
    $action = '<badge class="badge badge-danger">DELETE DATA</badge>';
    $keterangan = "Delete data Ijazah dari menu <b>" . $menu . "</b> dengan title : <b>" . $nama . "</b> , By : <b>" . $name . "</b>";

    history($title, $action, $keterangan);

    $alert = array(
      'type' => 'info',
      'message' => 'Data berhasil di hapus'
    );

    return redirect()->back()->with($alert);
	}

	public function npwp(Request $request)
	{
		$id = $request->id;

    $get = Employee::find($id);

    $data = [
      'get' => $get
    ];
    return view('backend.employee.detail.upload_npwp')->with($data);
	}

	public function npwp_update(Request $request, $id)
	{
		$name = auth()->user()->email;
    $menu = "Data Karyawan";

    $get = Employee::find($id);
    $nik = $get->nik;
    $nama = $get->name;
		$file = $get->npwp;

    $image = $request->file('file');

    if (!empty($image)) 
		{
			if(isset($file))
			{
				removeFile($nik, $file);
			}
			
      $input['imagename'] = 'npwp_'.$nik.'_'.time().'.'. $image->extension();
      $path = public_path('/storage/upload/employee/' . $nik . '/');
      if (!FacadesFile::isDirectory($path)) {
        FacadesFile::makeDirectory($path);
      }
      $image->move($path, $input['imagename']);
      $origin = $input['imagename'];

      $data = [
        'npwp' => $origin,
        'npwp_no' => $request->npwp_no
      ];

      Employee::find($id)->update($data);
    }

    $title = $name;
    $action = '<badge class="badge badge-info">UPDATE DATA</badge>';
    $keterangan = "Update data NPWP dari menu <b>" . $menu . "</b> dengan title : <b>" . $nama . "</b> , By : <b>" . $name . "</b>";

    history($title, $action, $keterangan);

    $alert = array(
      'type' => 'info',
      'message' => 'Data berhasil di update'
    );

    return redirect()->back()->with($alert);
	}

	public function npwp_view(Request $request)
	{
		$get = Employee::find($request->id);

		$file = $get->npwp;

		$exp = explode('.',$file);

		$data = [
			'title' => 'File NPWP - '.$get->name,
			'file_type' => $exp[1],
			'file' => $file,
			'nik' => $get->nik
		];

		return view('backend.employee.detail.document_view')->with($data);
	}

	public function npwp_delete($id)
	{
		$name = auth()->user()->email;
    $menu = "Data Karyawan";

    $get = Employee::find($id);
    $nik = $get->nik;
    $nama = $get->name;
		$file = $get->kk;

		if(isset($file))
		{
			removeFile($nik, $file);
		}

		$data = [
			'npwp' => NULL,
			'npwp_no' => NULL
		];

		Employee::find($id)->update($data);

    $title = $name;
    $action = '<badge class="badge badge-danger">DELETE DATA</badge>';
    $keterangan = "Delete data NPWP dari menu <b>" . $menu . "</b> dengan title : <b>" . $nama . "</b> , By : <b>" . $name . "</b>";

    history($title, $action, $keterangan);

    $alert = array(
      'type' => 'info',
      'message' => 'Data berhasil di hapus'
    );

    return redirect()->back()->with($alert);
	}

	public function vaksin(Request $request)
	{
		$id = $request->id;

		$type = VaksinType::pluck('title','id');

		$data = [
			'id' => $id,
			'type' => $type
		];
		
		return view('backend.employee.detail.vaksin')->with($data);
	}

	public function bukti_padan(Request $request)
	{
		$id = $request->id;

    $get = Employee::find($id);

    $data = [
      'get' => $get
    ];
    return view('backend.employee.detail.upload_bukti_padan')->with($data);
	}

	public function bukti_padan_update(Request $request, $id)
	{
		$name = auth()->user()->email;
    $menu = "Data Karyawan";

		// dd($request->all());

    $get = Employee::find($id);
    $nik = $get->nik;
    $nama = $get->name;
		$file = $get->bukti_padan;

    $image = $request->file('file');

    if (!empty($image)) 
		{
			if(isset($file))
			{
				removeFile($nik, $file);
			}

      $input['imagename'] = 'bukti_padan_'.$nik.'_'.time().'.'. $image->extension();
      $path = public_path('/storage/upload/employee/' . $nik . '/');
      if (!FacadesFile::isDirectory($path)) {
        FacadesFile::makeDirectory($path);
      }
      $image->move($path, $input['imagename']);
      $origin = $input['imagename'];

      $data = [
        'bukti_padan_file' => $origin,
        'bukti_padan' => $request->bukti_padan
      ];

      Employee::find($id)->update($data);
    }

    $title = $name;
    $action = '<badge class="badge badge-info">UPDATE DATA</badge>';
    $keterangan = "Update data Bukti Padan NPWP dari menu <b>" . $menu . "</b> dengan title : <b>" . $nama . "</b> , By : <b>" . $name . "</b>";

    history($title, $action, $keterangan);

    $alert = array(
      'type' => 'info',
      'message' => 'Data berhasil di update'
    );

    return redirect()->back()->with($alert);
	}

	public function bukti_padan_view(Request $request)
	{
		$get = Employee::find($request->id);

		$file = $get->bukti_padan_file;

		$exp = explode('.',$file);

		$data = [
			'title' => 'File Bukti Padan NPWP - '.$get->name,
			'file_type' => $exp[1],
			'file' => $file,
			'nik' => $get->nik
		];

		return view('backend.employee.detail.document_view')->with($data);
	}

	public function bukti_padan_delete($id)
	{
		$name = auth()->user()->email;
    $menu = "Data Karyawan";

    $get = Employee::find($id);
    $nik = $get->nik;
    $nama = $get->name;
		$file = $get->kk;

		if(isset($file))
		{
			removeFile($nik, $file);
		}

		$data = [
			'bukti_padan_file' => NULL,
			'bukti_padan' => NULL
		];

		Employee::find($id)->update($data);

    $title = $name;
    $action = '<badge class="badge badge-danger">DELETE DATA</badge>';
    $keterangan = "Delete data Bukti Padan dari menu <b>" . $menu . "</b> dengan title : <b>" . $nama . "</b> , By : <b>" . $name . "</b>";

    history($title, $action, $keterangan);

    $alert = array(
      'type' => 'info',
      'message' => 'Data berhasil di hapus'
    );

    return redirect()->back()->with($alert);
	}

	public function export(Request $request)
	{
		$tipe = [
			'all' => 'Semua Karyawan',
			'active' => 'Karyawan Aktif',
			'resign' => 'Karyawan Resign'
		];

		$data = [
			'tipe' => $tipe
		];

		return view('backend.employee.export')->with($data);
	}

	public function export_proses(Request $request)
	{
		$tipe = $request->tipe;

		$row = $this->service->export($tipe);

		$header_style = (new Style())->setFontBold();
		
		$rows_style = (new Style())->setFontSize(11)
															 ->setShouldShrinkToFit();

		return (new FastExcel($row))->headerStyle($header_style)
																->rowsStyle($rows_style)
																->download('file_export_karyawan_'.time().'.xlsx');
	}

	public function reactive($id)
	{
		$data = [
			'resign_date' => NULL,
			'resign_types_id' => NULL,
			'resign_reason' => NULL,
			'resign_statuses_id' => NULL,
			'resign_st' => NULL,
			'resign_interview_st' => NULL,
			'resign_clearance_st' => NULL
		];

		Employee::find($id)->update($data);

		$alert = array(
      'type' => 'info',
      'message' => 'Karyawan berhasil di aktifkan kembali'
    );

    return redirect()->back()->with($alert);
	}

	public function verifikasi_employee()
	{
		$assets = [
      'style' => array(
        'assets/js/plugins/air-datepicker/css/datepicker.min.css'
      ),
      'script' => array(
				'assets/js/plugins/air-datepicker/js/datepicker.min.js',
				'assets/js/plugins/air-datepicker/js/i18n/datepicker.en.js'
      )
    ];

		$data = [
      'title' => 'Verifikasi - Calon Karyawan',
			'section' => 'karyawan',
			'sub_section' => 'data_verifikasi_karyawan',
			'assets' => $assets
    ];

		return view('backend.employee.verify.index')->with($data);
	}

	public function verifikasi_employee_search(Request $request)
	{
		$cek = Employee::where('tgl_lahir',$request->tanggal_lahir)
									 ->where('ktp_no',$request->ktp_no)
									 ->orderBy('id','ASC')
									 ->get();


		if (count($cek) > 0) 
		{
			foreach ($cek as $key => $value) 
			{
				if ($value->resign_st==1) 
				{
					$status = '<span class="badge badge-danger">Non Active</span>';
					$keterangan = $value->resign_type.' - '.$value->resign_reason;
				}
				else
				{
					$status = '<span class="badge badge-success">Active</span>';
					$keterangan = '-';
				}
			

				$row[] = [
					'nik' => $value->nik,
					'name' => $value->name,
					'department' => isset($value->department) ? $value->department->title : '-',
					'posisi' => isset($value->jabatan) ? $value->jabatan->title : '-',
					'lokasi' => $value->lokasi_detail->title,
					'status' => $status,
					'keterangan' => $keterangan,
					'join_date' => $value->join_date,
					'resign_date' => isset($value->resign_date) ? $value->resign_date : '-'
				];
			}
		}
		else
		{
			$row = [];
		}


		$data = [
			'row' => $row
		];

		return view('backend.employee.verify.view')->with($data);
	}
}
