<?php

namespace App\Services\Surat;

use App\Models\ApprovalHr;
use App\Models\SuratTugas;
use App\Models\User;
use App\Models\UserLokasi;

class TugasServices
{
	public function data()
	{
		$role = auth()->user()->role_id;
    $users_id = auth()->user()->id;

		$year = date('Y');

    if ($role == 1 || $role == 2 || $role == 3) 
		{
      $get = SuratTugas::whereYear('date',$year)
												->orderBy('id','DESC')
												->get();
    } 
		else 
		{
      $user_lokasi = UserLokasi::where('users_id', $users_id)->pluck('lokasi_id');
      $get = SuratTugas::whereYear('date',$year)
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

		$data = [
			'user' => $user
		];

		return $data;
	}

	public function store($data)
	{
		$name = auth()->user()->email;
    $menu = "Surat Tugas";

		$kd = 'ST-'.time();

		// dd($data);

		$get = User::find($data['users_id']);
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

		$data = [
			'kd' => $kd,
			'employee_id' => $data['users_id'],
			'date' => date('Y-m-d'),
			'date_start' => $data['date_start'],
			'date_end' => $data['date_end'],
			'department_id' => $department_id,
			'jabatan_id' => $jabatan_id,
			'department_jabatan_id' => $department_jabatan_id,
			'divisi_id' => $divisi_id,
			'periksa_id' => $periksa,
			'approval1_id' => $setujui,
			'approval2_id' => $mengetahui,
			'lokasi_id' => $lokasi,
			'desc' => $data['desc'],
			'catatan' => $data['catatan'],
			'approval' => 0
		];

		SuratTugas::create($data);

		// $no_wa = '085250038002';
		$no_wa = $hrd_no;
		$pengajuan = 'Surat Tugas';
		$status = 'periksa';
		$otp = $this->random_number();
		$encoded = base64_encode(time().'&'.$kd.'&'.$otp.'&'.$periksa.'&'.$status);
		$url = 'approval/surat/tugas/' . str_replace('=', '', $encoded);
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

		$row = SuratTugas::where('kd',$kd)->first();

		$approval = User::find($row->approval1_id);

		$data = [
      'periksa_st' => 1
    ];

    SuratTugas::where('id',$row->id)->update($data);

		$employee_name = $row->employee->name;
		$approval_name = $approval->name;
		$approval_hp = $approval->no_hp;

		$wa_no = $approval_hp;
		$pengajuan = 'Surat Tugas';
		$status = 'approval1';
		$otp = $this->random_number();
		$encoded = base64_encode(time().'&'.$kd.'&'.$otp.'&'.$row->approval1_id.'&'.$status);
    $url = 'approval/surat/tugas/' . str_replace('=', '', $encoded);
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

		$row = SuratTugas::where('kd',$kd)->first();

		$approval = User::find($row->approval2_id);

		$data = [
      'approval1_st' => 1,
      'approval' => 1
    ];

    SuratTugas::where('id',$row->id)->update($data);

		$employee_name = $row->employee->name;
		$approval_name = $approval->name;
		$approval_hp = $approval->no_hp;

		$wa_no = $approval_hp;
		$pengajuan = 'Surat Tugas';
		$status = 'approval2';
		$otp = $this->random_number();
		$encoded = base64_encode(time().'&'.$kd.'&'.$otp.'&'.$row->approval2_id.'&'.$status);
    $url = 'approval/surat/tugas/' . str_replace('=', '', $encoded);
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

		$row = SuratTugas::where('kd',$kd)->first();

		$employee_name = $row->employee->name;

		$data = [
      'approval2_st' => 1
    ];

    SuratTugas::where('id',$row->id)->update($data);

		$wa_no = $row->employee->no_hp;
		$pengajuan = 'Surat Tugas';
		$status = 'approve';
		$otp = $this->random_number();
		$encoded = base64_encode(time().'&'.$kd.'&'.$otp.'&'.$row->employee_id);
    $url = 'approval/surat/tugas/' . str_replace('=', '', $encoded);
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

		$row = SuratTugas::where('kd',$kd)->first();

		$data = [
			'periksa_st' => 0,
			'approval1_st' => 0,
      'approval2_st' => 0,
			'approval' => 2,
			'reject_id' => $approval,
			'reject_excuse' => $post['reject_excuse']
    ];

    SuratTugas::where('id',$row->id)->update($data);

		$reject_user = User::find($approval);

		$employee_name = $row->employee->name;
		$approval_name = $reject_user->name;

		$wa_no = $row->employee->no_hp;
		$pengajuan = 'Surat Tugas';
		$status = 'reject';
		$otp = $this->random_number();
		$encoded = base64_encode(time().'&'.$kd.'&'.$otp);
    $url = 'approval/surat/tugas/' . str_replace('=', '', $encoded);
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
    SuratTugas::find($id)->delete();

		$result = [
			'message' => 'sukses'
		];

    return $result;
  }

	public function detail($kd)
	{
		return SuratTugas::where('kd',$kd)->first();
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