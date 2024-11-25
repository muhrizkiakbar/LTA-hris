<?php

namespace App\Services\Surat;

use App\Models\ApprovalHr;
use App\Models\SuratIjin;
use App\Models\SuratIjinTipe;
use App\Models\User;
use App\Models\UserLokasi;

class IjinServices
{
	public function data()
	{
		$role = auth()->user()->role_id;
    $users_id = auth()->user()->id;

		$year = date('Y');

    if ($role == 1 || $role == 2 || $role == 3) 
		{
      $get = SuratIjin::whereYear('date',$year)
											->orderBy('id','DESC')
											->get();
    } 
		else 
		{
      $user_lokasi = UserLokasi::where('users_id', $users_id)->pluck('lokasi_id');
      $get = SuratIjin::whereYear('date',$year)
											->whereIn('lokasi_id',$user_lokasi)
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

		$tipe = SuratIjinTipe::pluck('title','id');

		$data = [
			'user' => $user,
			'tipe' => $tipe
		];

		return $data;
	}

	public function store($data)
	{
		$nik = auth()->user()->name;
    $menu = "Surat Ijin Meninggalkan Tempat Kerja";

		$kd = 'SIM-'.time();
		$employee = $data['employee_id'];

		$get = User::find($employee);
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
    $setujui = get_cuti_setujui($employee, $lokasi);
    $mengetahui = get_cuti_setujui($setujui, $lokasi);

		$data = [
      'kd' => $kd,
      'employee_id' => $employee,
      'tgl_input' => date('Y-m-d'),
      'date' => $data['date'],
      'time_start' => $data['time_start'],
      'time_end' => $data['time_end'],
      'tipe' => $data['tipe'],
      'keperluan' => $data['keperluan'],
      'status' => 0,
      'created_by' => $nik,
      'department_id' => $department_id,
      'divisi_id' => $divisi_id,
      'jabatan_id' => $jabatan_id,
      'department_jabatan_id' => $department_jabatan_id,
      'periksa_id' => $periksa,
      'approval1_id' => $setujui,
      'approval2_id' => $mengetahui,
      'lokasi_id' => $lokasi
    ];

		SuratIjin::create($data);

		// $no_wa = '085250038002';
		$no_wa = $hrd_no;
		$pengajuan = 'Surat Ijin Meninggalkan Tempat Kerja';
		$status = 'periksa';
		$otp = $this->random_number();
		$encoded = base64_encode(time().'&'.$kd.'&'.$otp.'&'.$periksa.'&'.$status);
		$url = 'approval/surat/ijin/' . str_replace('=', '', $encoded);
		$teks_otp = "Kode OTP : *".intval($otp)."*";
		$message = whatsappMessage($employee_name, $pengajuan, $approval_name, $kd, $status, '');

		$this->send_wa($no_wa, $url, $message['subject'], $message['message'], $get->id, $teks_otp);

		$response = [
			'message' => 'sukses'
		];

		return $response;
	}

	public function periksa($code)
	{
		$url_decode = base64_decode($code);
    $exp = explode('&',$url_decode);

		$kd = $exp[1];

		$row = SuratIjin::where('kd',$kd)->first();

		$approval = User::find($row->approval1_id);

		$data = [
      'periksa_st' => 1
    ];

    SuratIjin::where('id',$row->id)->update($data);

		$employee_name = $row->employee->name;
		$approval_name = $approval->name;
		$approval_hp = $approval->no_hp;

		$wa_no = $approval_hp;
		$pengajuan = 'Surat Ijin Meninggalkan Tempat Kerja';
		$status = 'approval1';
		$otp = $this->random_number();
		$encoded = base64_encode(time().'&'.$kd.'&'.$otp.'&'.$row->approval1_id.'&'.$status);
    $url = 'approval/surat/ijin/' . str_replace('=', '', $encoded);
		$teks_otp = "Kode OTP : *".intval($otp)."*";
		$message = whatsappMessage($employee_name, $pengajuan, $approval_name, $kd, $status, '');

		$this->send_wa($wa_no, $url, $message['subject'], $message['message'], $row->employee_id, $teks_otp);

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

		$row = SuratIjin::where('kd',$kd)->first();

		$approval = User::find($row->approval2_id);

		$data = [
      'approval1_st' => 1,
      'status' => 1
    ];

    SuratIjin::where('id',$row->id)->update($data);

		$employee_name = $row->employee->name;
		$approval_name = $approval->name;
		$approval_hp = $approval->no_hp;

		$wa_no = $approval_hp;
		$pengajuan = 'Surat Ijin Meninggalkan Tempat Kerja';
		$status = 'approval2';
		$otp = $this->random_number();
		$encoded = base64_encode(time().'&'.$kd.'&'.$otp.'&'.$row->approval2_id.'&'.$status);
    $url = 'approval/surat/ijin/' . str_replace('=', '', $encoded);
		$teks_otp = "Kode OTP : *".intval($otp)."*";
		$message = whatsappMessage($employee_name, $pengajuan, $approval_name, $kd, $status, '');

		$this->send_wa($wa_no, $url, $message['subject'], $message['message'], $row->employee_id, $teks_otp);

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

		$row = SuratIjin::where('kd',$kd)->first();

		$employee_name = $row->employee->name;

		$data = [
      'approval2_st' => 1
    ];

    SuratIjin::where('id',$row->id)->update($data);

		$wa_no = $row->employee->no_hp;
		$pengajuan = 'Surat Ijin Meninggalkan Tempat Kerja';
		$status = 'approve';
		$otp = $this->random_number();
		$encoded = base64_encode(time().'&'.$kd.'&'.$otp.'&'.$row->employee_id);
    $url = 'approval/surat/ijin/' . str_replace('=', '', $encoded);
		$teks_otp = "Kode OTP : *".intval($otp)."*";
		$message = whatsappMessage($employee_name, $pengajuan, '', $kd, $status, '');

		$this->send_wa($wa_no, $url, $message['subject'], $message['message'], $row->employee_id, $teks_otp);

    $response = [
			'message' => 'sukses'
		];

		return $response;
	}

	public function reject($post)
	{
		$kd = $post['kd'];
		$approval = $post['approval'];

		$row = SuratIjin::where('kd',$kd)->first();

		$data = [
			'periksa_st' => 0,
			'approval1_st' => 0,
      'approval2_st' => 0,
			'status' => 2,
			'reject_id' => $approval,
			'reject_excuse' => $post['reject_excuse']
    ];

    SuratIjin::where('id',$row->id)->update($data);

		$reject_user = User::find($approval);

		$employee_name = $row->employee->name;
		$approval_name = $reject_user->name;

		$wa_no = $row->employee->no_hp;
		$pengajuan = 'Surat Ijin Meninggalkan Tempat Kerja';
		$status = 'reject';
		$otp = $this->random_number();
		$encoded = base64_encode(time().'&'.$kd.'&'.$otp);
    $url = 'approval/surat/ijin/' . str_replace('=', '', $encoded);
		$teks_otp = "Kode OTP : *".intval($otp)."*";
		$message = whatsappMessage($employee_name, $pengajuan, $approval_name, $kd, $status, $post['reject_excuse']);

		$this->send_wa($wa_no, $url, $message['subject'], $message['message'], $row->employee_id, $teks_otp);

    $response = [
			'message' => 'sukses'
		];

		return $response;
	}

	public function delete($id)
  {
    SuratIjin::find($id)->delete();

		$result = [
			'message' => 'sukses'
		];

    return $result;
  }

	public function detail($kd)
	{
		return SuratIjin::where('kd',$kd)->first();
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