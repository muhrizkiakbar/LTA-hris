<?php

namespace App\Services\Absensi;

use App\Models\AbsensiIjin;
use App\Models\AbsensiIjinLines;
use App\Models\AbsensiIjinType;
use App\Models\ApprovalHr;
use App\Models\User;
use App\Models\UserLokasi;
use Illuminate\Support\Facades\File as FacadesFile;

class IjinServices
{
	public function data()
	{
		$role = auth()->user()->role_id;
    $users_id = auth()->user()->id;

		$year = date('Y');
		$yearx = $year-1;

    if ($role == 1 || $role == 2 || $role == 3) 
		{
      $get = AbsensiIjin::whereYear('date_start','>=',$yearx)
												->orderBy('id','DESC')
												->get();
    } 
		else 
		{
      $user_lokasi = UserLokasi::where('users_id', $users_id)->pluck('lokasi_id');
      $get = AbsensiIjin::whereIn('lokasi_id',$user_lokasi)
												->whereYear('date_start','>=',$yearx)
												->orderBy('id','DESC')
												->get();
    }

		return $get;
	}

	public function pluck_data()
	{
		$role = auth()->user()->role_id;
    $users_id = auth()->user()->id;

    if ($role == 1 || $role == 2 || $role==3) 
		{
      $user = User::where('role_id', 5)
                 ->whereNull('resign_st')
                 ->pluck('name','id');
    } 
		else 
		{
      $user_lokasi = UserLokasi::where('users_id', $users_id)->pluck('lokasi_id');
      $user = User::where('role_id', 5)
                 ->whereNull('resign_st')
                 ->whereIn('lokasi_id', $user_lokasi)
                 ->pluck('name','id');
    }

    $type = AbsensiIjinType::pluck('title','id');

		$data = [
			'user' => $user,
			'type' => $type
		];

		return $data;
	}

	public function store($data)
	{
		$name = auth()->user()->email;
    $menu = "Absensi Ijin Karyawan";

		$kd = "SIK-".time();

		$file = isset($data['file']) ? $data['file'] : '';
		$tipe = $data['absensi_ijin_type_id'];

		$get = User::find($data['users_id']);
		$nik = $get->nik;
    $employee_name = $get->name;
    $lokasi = $get->lokasi_id;
		$department_id = $get->department_id;
    $divisi_id = $get->divisi_id;
    $jabatan_id = $get->jabatan_id;
    $department_jabatan_id = $get->department_jabatan_id;

    $hrd = ApprovalHr::where('lokasi_id', $lokasi)->first();
    $hrd_no = $hrd->employee->no_hp;
    $approval_name = $hrd->employee->name;

		$periksa = get_cuti_periksa($lokasi);
    $setujui = get_cuti_setujui($data['users_id'], $lokasi);
    $mengetahui = get_cuti_setujui($setujui, $lokasi);

		$type = AbsensiIjinType::find($tipe);

		if($tipe==5)
    {
			$data = [
        'kd' => $kd,
        'users_id' => $data['users_id'],
        'date_start' => $data['date_start'],
        'date_end' => $data['date_end'],
        'absensi_ijin_type_id' => $tipe,
        'department_id' => $department_id,
        'jabatan_id' => $jabatan_id,
        'department_jabatan_id' => $department_jabatan_id,
        'divisi_id' => $divisi_id,
        'periksa_id' => $periksa,
        'periksa_st' => 1,
        'approval1_id' => $setujui,
        'approval1_st' => 1,
        'approval2_id' => $mengetahui,
        'approval2_st' => 1,
        'lokasi_id' => $lokasi,
        'keterangan' => $data['keterangan']
      ];

			$post = AbsensiIjin::create($data);
      if ($post) 
      {
				$date_start = $data['date_start'];
        $date_from = date ("Y-m-d", strtotime("-1 day", strtotime($date_start)));
        $date_end = $data['date_end'];
        while (strtotime($date_from) < strtotime($date_end)) 
        {
          $date_from = date ("Y-m-d", strtotime("+1 day", strtotime($date_from)));//looping tambah 1 date
          $data2 = [
            'absensi_ijin_id' => $post->id,
            'users_id' => $data['users_id'],
            'date' => $date_from,
            'absensi_ijin_type_id' => $tipe,
            'status' => 1
          ];

          AbsensiIjinLines::create($data2);
        }
			}
		}
		else
		{
			if(empty($file))
      {
        $data = [
          'kd' => $kd,
          'users_id' => $data['users_id'],
					'date_start' => $data['date_start'],
					'date_end' => $data['date_end'],
          'absensi_ijin_type_id' => $tipe,
          'department_id' => $department_id,
          'jabatan_id' => $jabatan_id,
          'department_jabatan_id' => $department_jabatan_id,
          'divisi_id' => $divisi_id,
          'periksa_id' => $periksa,
          'approval1_id' => $setujui,
          'approval2_id' => $mengetahui,
          'lokasi_id' => $lokasi,
          'keterangan' => $data['keterangan']
        ];
      }
      else
      {
        $input['imagename'] = 'absensi_ijin_file_' . time() . '.' . $file->extension();
        $path = public_path('/storage/upload/employee/' . $nik . '/');
        if (!FacadesFile::isDirectory($path)) {
          FacadesFile::makeDirectory($path);
        }

        $file->move($path, $input['imagename']);
        $origin = $input['imagename'];

        $data = [
          'kd' => $kd,
          'users_id' => $data['users_id'],
					'date_start' => $data['date_start'],
					'date_end' => $data['date_end'],
          'absensi_ijin_type_id' => $tipe,
          'department_id' => $department_id,
          'jabatan_id' => $jabatan_id,
          'department_jabatan_id' => $department_jabatan_id,
          'divisi_id' => $divisi_id,
          'periksa_id' => $periksa,
          'approval1_id' => $setujui,
          'approval2_id' => $mengetahui,
          'file' => $origin,
          'lokasi_id' => $lokasi,
          'keterangan' => $data['keterangan']
        ];
      }

      $post = AbsensiIjin::create($data);
      if ($post) 
      {
        $date_start = $data['date_start'];
        $date_from = date ("Y-m-d", strtotime("-1 day", strtotime($date_start)));
        $date_end = $data['date_end'];
        while (strtotime($date_from) < strtotime($date_end)) 
        {
          $date_from = date ("Y-m-d", strtotime("+1 day", strtotime($date_from)));//looping tambah 1 date
          $data2 = [
            'absensi_ijin_id' => $post->id,
            'users_id' => $data['users_id'],
            'date' => $date_from,
            'absensi_ijin_type_id' => $tipe,
            'status' => 1
          ];

          AbsensiIjinLines::create($data2);
        }
      }

			$pengajuan = 'Absensi Ijin Karyawan';
			$status = 'periksa';
			$otp = $this->random_number();
			$encoded = base64_encode(time().'&'.$kd.'&'.$otp.'&'.$periksa.'&'.$status);
			$url = 'approval/absensi/ijin/' . str_replace('=', '', $encoded);
			$teks_otp = "Kode OTP : *".intval($otp)."*";
			$message = whatsappMessage($employee_name, $pengajuan, $approval_name, $kd, $status, '');

			$this->send_wa($hrd_no, $url, $message['subject'], $message['message'], $data['users_id'], $teks_otp);
		}

		$title = $name;
    $action = '<badge class="badge badge-success">INSERT DATA</badge>';
    $keterangan = "Input data baru dari menu <b>" . $menu . "</b> dengan nama : <b>" . $get->name . "</b> keterangan : <b>". $type->title ."</b> , By : <b>" . $name . "</b>";

    history($title, $action, $keterangan);

    $response = [
			'message' => 'sukses'
		];

		return $response;
	}

	public function detail($kd)
	{
		return AbsensiIjin::where('kd',$kd)->first();
	}

	public function periksa($code)
	{
		$url_decode = base64_decode($code);
    $exp = explode('&',$url_decode);

		$kd = $exp[1];

		$row = AbsensiIjin::where('kd',$kd)->first();

		$approval = User::find($row->approval1_id);

		$data = [
      'periksa_st' => 1
    ];

    AbsensiIjin::where('id',$row->id)->update($data);

		$employee_name = $row->employee->name;
		$approval_name = $approval->name;
		$approval_hp = $approval->no_hp;

		$wa_no = $approval_hp;
		$pengajuan = 'Absensi Ijin Karyawan';
		$status = 'approval1';
		$otp = $this->random_number();
		$encoded = base64_encode(time().'&'.$kd.'&'.$otp.'&'.$row->approval1_id.'&'.$status);
    $url = 'approval/absensi/ijin/' . str_replace('=', '', $encoded);
		$teks_otp = "Kode OTP : *".intval($otp)."*";
		$message = whatsappMessage($employee_name, $pengajuan, $approval_name, $kd, $status, '');

		$this->send_wa($wa_no, $url, $message['subject'], $message['message'], $row->users_id, $teks_otp);

    $response = [
			'message' => 'sukses'
		];

		return $response;
	}

	public function setuju($code)
	{
		$url_decode = base64_decode($code);
    $exp = explode('&',$url_decode);

		$kd = $exp[1];

		$row = AbsensiIjin::where('kd',$kd)->first();

		$approval = User::find($row->approval2_id);

		$data = [
      'approval1_st' => 1,
      'status' => 1
    ];

    AbsensiIjin::where('id',$row->id)->update($data);

		$data_lines = [
      'status' => 1
    ];

    AbsensiIjinLines::where('absensi_ijin_id',$row->id)->update($data_lines);

		$employee_name = $row->employee->name;
		$approval_name = $approval->name;
		$approval_hp = $approval->no_hp;

		$wa_no = $approval_hp;
		$pengajuan = 'Absensi Ijin Karyawan';
		$status = 'approval2';
		$otp = $this->random_number();
		$encoded = base64_encode(time().'&'.$kd.'&'.$otp.'&'.$row->approval2_id.'&'.$status);
    $url = 'approval/absensi/ijin/' . str_replace('=', '', $encoded);
		$teks_otp = "Kode OTP : *".intval($otp)."*";
		$message = whatsappMessage($employee_name, $pengajuan, $approval_name, $kd, $status, '');

		$this->send_wa($wa_no, $url, $message['subject'], $message['message'], $row->users_id, $teks_otp);

    $response = [
			'message' => 'sukses'
		];

		return $response;
	}

	public function ketahui($code)
	{
		$url_decode = base64_decode($code);
    $exp = explode('&',$url_decode);

		$kd = $exp[1];

		$row = AbsensiIjin::where('kd',$kd)->first();

		$data = [
      'approval2_st' => 1
    ];

    AbsensiIjin::where('id',$row->id)->update($data);

		$employee_name = $row->employee->name;

		$wa_no = $row->employee->no_hp;
		$pengajuan = 'Absensi Ijin Karyawan';
		$status = 'approve';
		$otp = $this->random_number();
		$encoded = base64_encode(time().'&'.$kd.'&'.$otp.'&'.$row->users_id);
    $url = 'approval/absensi/ijin/' . str_replace('=', '', $encoded);
		$teks_otp = "Kode OTP : *".intval($otp)."*";
		$message = whatsappMessage($employee_name, $pengajuan, '', $kd, $status, '');

		$this->send_wa($wa_no, $url, $message['subject'], $message['message'], $row->users_id, $teks_otp);

    $response = [
			'message' => 'sukses'
		];

		return $response;
	}

	public function reject($post)
	{
		$kd = $post['kd'];
		$approval = $post['approval'];

		$row = AbsensiIjin::where('kd',$kd)->first();

		$data = [
			'periksa_st' => 0,
			'approval1_st' => 0,
      'approval2_st' => 0,
			'status' => 2,
			'reject_id' => $approval,
			'reject_excuse' => $post['reject_excuse']
    ];

    AbsensiIjin::where('id',$row->id)->update($data);

		$data_lines = [
      'status' => 0
    ];

    AbsensiIjinLines::where('absensi_ijin_id',$row->id)->update($data_lines);

		$reject_user = User::find($approval);

		$employee_name = $row->employee->name;
		$approval_name = $reject_user->name;

		$wa_no = $row->employee->no_hp;
		$pengajuan = 'Absensi Ijin Karyawan';
		$status = 'reject';
		$otp = $this->random_number();
		$encoded = base64_encode(time().'&'.$kd.'&'.$otp);
    $url = 'approval/absensi/ijin/' . str_replace('=', '', $encoded);
		$teks_otp = "Kode OTP : *".intval($otp)."*";
		$message = whatsappMessage($employee_name, $pengajuan, $approval_name, $kd, $status, $post['reject_excuse']);

		$this->send_wa($wa_no, $url, $message['subject'], $message['message'], $row->users_id, $teks_otp);

    $response = [
			'message' => 'sukses'
		];

		return $response;
	}

	public function send_wa($no_hp, $url, $subject, $new_message, $users_id, $teks_otp)
	{
		// $no_wa = '085250038002';
		$no_wa = $no_hp;
    $site = "https://hris.laut-timur.tech/";
    $teks_tengah = $site . $url;

		$message = sprintf("%s \n\n%s \n\n%s \n\n%s \n\nTerima Kasih", $subject, $new_message, $teks_tengah, $teks_otp);
		$send_wa = callWhatsapp2($no_wa, $message);

		whatsappMonitor($no_wa, $teks_tengah, $new_message, $subject, $send_wa['status'], $send_wa['message'], $users_id);
	}

	public function random_number()
	{
		return substr(number_format(time() * rand(1111,9999),0,'',''),0,4);
	}
}