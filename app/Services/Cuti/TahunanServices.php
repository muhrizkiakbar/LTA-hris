<?php

namespace App\Services\Cuti;

use App\Models\ApprovalHr;
use App\Models\CutiHeader;
use App\Models\CutiLines;
use App\Models\Department;
use App\Models\Mutasi;
use App\Models\User;
use App\Models\UserLokasi;
use DateTime;

class TahunanServices
{
	public function data()
	{
		$users_id = auth()->user()->id;
    $role = auth()->user()->role_id;
		$department = auth()->user()->department_id;
		$jabatan = auth()->user()->jabatan_id;

		$atasan = User::where('atasan_id',$users_id)->pluck('id');

		$year = date('Y')-1;

		if ($role==1 || $role==2 || $role==3) 
		{
			$get = CutiHeader::where('cuti_type_id',1)
											->whereYear('date','>=',$year)
											->orderBy('date','DESC')
											->orderBy('id','DESC')
											->get();
		}
		elseif($role==5)
		{
			if (count($atasan) > 0) 
			{
				if ($jabatan >= 3) 
				{
					$get = CutiHeader::where('cuti_type_id',1)
											->whereYear('date','>=',$year)
											->where('department_id',$department)
											->orderBy('date','DESC')
											->orderBy('id','DESC')
											->get();
				}
				else
				{
					$get = CutiHeader::where('cuti_type_id',1)
											->whereYear('date','>=',$year)
											->whereIn('employee_id',$atasan)
											->orderBy('date','DESC')
											->orderBy('id','DESC')
											->get();
				}
			}
			else
			{
				$get = CutiHeader::where('cuti_type_id',1)
											->whereYear('date','>=',$year)
											->where('employee_id',$users_id)
											->orderBy('date','DESC')
											->orderBy('id','DESC')
											->get();
			}
		}	
		else
		{
			$get_lokasi = UserLokasi::where('users_id', $users_id)->pluck('lokasi_id');
			$get = CutiHeader::where('cuti_type_id',1)
											->whereYear('date','>=',$year)
											->whereIn('lokasi_id',$get_lokasi)
											->orderBy('date','DESC')
											->orderBy('id','DESC')
											->get();
		}

		return $get;
	}

	public function select_create()
	{
		$users_id = auth()->user()->id;
    $role = auth()->user()->role_id;
		$department = auth()->user()->department_id;

		if ($role==1 || $role==2 || $role==3) 
		{
			$user = User::where('role_id',5)
									->whereNull('resign_st')
									->orderBy('nik','ASC')
									->get();
		}
		elseif($role==5)
		{
			$get_lokasi = auth()->user()->lokasi_id;
			$user = User::where('department_id',$department)
									->where('role_id',5)
									->whereNull('resign_st')
									->where('lokasi_id', $get_lokasi)
									->where('id','!=',$users_id)
									->orderBy('id','ASC')
									->get();
		}	
		else
		{
			$get_lokasi = UserLokasi::where('users_id', $users_id)->pluck('lokasi_id');
			$user = User::where('role_id',5)
									->whereNull('resign_st')
									->whereIn('lokasi_id', $get_lokasi)
									->orderBy('nik','ASC')
									->get();
		}

		$result = [
			'user' => $user
		];

		return $result;
	}

	public function store($data)
	{
		$name = auth()->user()->email;
    $menu = "Cuti Tahunan";

		$employee = $data['employee_id'];
    $tgl = $data['tgl'];
    $desc = $data['desc'];
    $employee_exchange = $data['employee_exchange_id'];

		$kd = 'CT-'.time();

		$getemployee = User::find($employee);
    $employee_name = $getemployee->name;
    $join_date = $getemployee->join_date;
    $lokasi = $getemployee->lokasi_id;
    $department_id = $getemployee->department_id;
    $divisi_id = $getemployee->divisi_id;
    $jabatan_id = $getemployee->jabatan_id;
    $department_jabatan_id = $getemployee->department_jabatan_id;

		$cuti_qty = get_saldo_cuti($employee, $join_date, "now");

		$split = explode(', ', $tgl);
    $count = count($split);

    $count_tgl = $count - 1;

    $tgl_str = $split[0];
    $tgl_end = $split[$count_tgl];

		$cek_header = CutiHeader::where('cuti_type_id',1)
														->where('approval',0)
														->where('employee_id',$employee)
														->where('periode',date('Y'))
														->whereNull('deleted_at')
														->get();

		$cek_lines_exchange = CutiLines::where('date', '>=', $tgl_str)
																	->where('date', '<=', $tgl_end)
																	->where('employee_id', $employee_exchange)
																	->where('approval_st', '!=', 2)
																	->where('cuti_type_id',1)
																	->get();

		$cek_lines = CutiLines::where('date', '>=', $tgl_str)
													->where('date', '<=', $tgl_end)
													->where('employee_id', $employee)
													->where('approval_st', '!=', 2)
													->where('cuti_type_id',1)
													->get();

		$get_hr = ApprovalHr::where('lokasi_id', $lokasi)->first();
		$user_hr = $get_hr->users_id;
		$no_hr = $get_hr->employee->no_hp;
		$approval_name = $get_hr->employee->name;

		$periksa = get_cuti_periksa($lokasi);
    $setujui = get_cuti_setujui($employee, $lokasi);
    $mengetahui = get_cuti_setujui($setujui, $lokasi);

		// $no_wa = '085250038002';
		$no_wa = $no_hr;
		$pengajuan = 'Cuti Tahunan';
		$status = 'periksa';
		$otp = $this->random_number();
		$encoded = base64_encode(time().'&'.$kd.'&'.$otp.'&'.$periksa.'&'.$status);
		$url = 'approval/cuti/tahunan/' . str_replace('=', '', $encoded);
		$teks_otp = "Kode OTP : *".intval($otp)."*";
		$message = whatsappMessage($employee_name, $pengajuan, $approval_name, $kd, $status, '');

		$dateNow = date('Y-m-d');

		$fdate = $dateNow;
		$tdate = $tgl_str;
		$datetime1 = new DateTime($fdate);
		$datetime2 = new DateTime($tdate);
		$interval = $datetime1->diff($datetime2);
		$days = $interval->format('%a');

		if ($days < 7) 
		{
			$result = [
				'message' => 'error_min_days'
			];
		}
		else
		{
			if ($cek_header->count() > 0) 
			{
				$result = [
					'message' => 'error_already_header'
				];
			}
			else
			{
				if ($cek_lines_exchange->count() > 0) 
				{
					$result = [
						'message' => 'error_already_exchange'
					];
				} 
				else
				{
					if ($cek_lines->count() > 0) 
					{
						$result = [
							'message' => 'error_already'
						];
					} 
					else 
					{
						if(empty($department_id) && empty($divisi_id))
						{
							$result = [
								'message' => 'error_notfound'
							];
						}
						else
						{
							$date_expired = date('Y-m-d',strtotime('-5 days', strtotime($tgl_str)));

							$data = [
								'kd' => $kd,
								'employee_id' => $employee,
								'employee_exchange_id' => $employee_exchange,
								'cuti_type_id' => 1,
								'date' => date('Y-m-d'),
								'desc' => $desc,
								'approval' => 0,
								'periode' => date('Y'),
								'periode_type' => 1,
								'cuti_qty' => $cuti_qty,
								'lama_cuti' => $count,
								'lokasi_id' => $lokasi,
								'department_id' => $department_id,
								'jabatan_id' => $jabatan_id,
								'department_jabatan_id' => $department_jabatan_id,
								'divisi_id' => $divisi_id,
								'periksa_id' => $periksa,
								'approval1_id' => $setujui,
								'approval2_id' => $mengetahui,
								'date_expired' => $date_expired
							];
				
							$post = CutiHeader::create($data);
				
							if ($post) 
							{
								foreach ($split as $date) 
								{
									$data2[] = [
										'cuti_header_id' => $post->id,
										'employee_id' => $employee,
										'date' => date('Y-m-d', strtotime($date)),
										'cuti_type_id' => 1,
										'approval_st' => 0,
										'desc' => $desc,
										'value' => '-1'
									];
								}
				
								CutiLines::insert($data2);
							}

							$title = $name;
							$action = '<badge class="badge badge-danger">INSERT DATA</badge>';
							$keterangan = "Insert data dari menu <b>" . $menu . "</b> tanggal : <b>" . $date . "</b> , By : <b>" . $name . "</b>";
				
							history($title, $action, $keterangan);

							$this->send_wa($no_wa, $url, $message['subject'], $message['message'], $employee, $teks_otp);

							$result = [
								'message' => 'sukses'
							];
						}
					}
				}
			}
		}

		

		return $result;
	}

	public function delete($id)
  {
    CutiHeader::find($id)->delete();
    CutiLines::where('cuti_header_id',$id)->delete();

		$result = [
			'message' => 'sukses'
		];

    return $result;
  }

	public function detail($kd)
	{
		return CutiHeader::where('kd',$kd)->first();
	}

	public function periksa($code)
	{
		$url_decode = base64_decode($code);
    $exp = explode('&',$url_decode);

		$kd = isset($exp[1]) ? $exp[1] : $code;

		$row = CutiHeader::where('kd',$kd)->first();

		$approval = User::find($row->approval1_id);

		$data = [
      'periksa_st' => 1
    ];

    CutiHeader::where('id',$row->id)->update($data);

		$employee_name = $row->employee->name;
		$approval_name = $approval->name;
		$approval_hp = $approval->no_hp;

		$wa_no = $approval_hp;
		$pengajuan = 'Cuti Tahunan';
		$status = 'approval1';
		$otp = $this->random_number();
		$encoded = base64_encode(time().'&'.$kd.'&'.$otp.'&'.$row->approval1_id.'&'.$status);
    $url = 'approval/cuti/tahunan/' . str_replace('=', '', $encoded);
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

		$kd = isset($exp[1]) ? $exp[1] : $code;

		$row = CutiHeader::where('kd',$kd)->first();

		$approval = User::find($row->approval2_id);

		
		$employee_name = $row->employee->name;
		$approval_name = $approval->name;
		$approval_hp = $approval->no_hp;

		$wa_no = $approval_hp;
		$pengajuan = 'Cuti Tahunan';
		$status = 'approval2';
		$otp = $this->random_number();
		$encoded = base64_encode(time().'&'.$kd.'&'.$otp.'&'.$row->approval2_id.'&'.$status);
    $url = 'approval/cuti/tahunan/' . str_replace('=', '', $encoded);
		$teks_otp = "Kode OTP : *".intval($otp)."*";
		$message = whatsappMessage($employee_name, $pengajuan, $approval_name, $kd, $status, '');

		$this->send_wa($wa_no, $url, $message['subject'], $message['message'], $row->employee_id, $teks_otp);

		$data = [
			'approval' => 1,
      'approval1_st' => 1
    ];

		$data2 = [
      'approval_st' => 1
    ];

		CutiHeader::find($row->id)->update($data);
    CutiLines::where('cuti_header_id', $row->id)->update($data2);

		$result = [
			'message' => 'sukses'
		];

		return $result;
	}

	public function ketahui($code)
	{
		$url_decode = base64_decode($code);
    $exp = explode('&',$url_decode);

		$kd = isset($exp[1]) ? $exp[1] : $code;

		$row = CutiHeader::where('kd',$kd)->first();

		$employee_name = $row->employee->name;

		$wa_no = $row->employee->no_hp;
		$pengajuan = 'Cuti Tahunan';
		$status = 'approve';
		$otp = $this->random_number();
		$encoded = base64_encode(time().'&'.$kd.'&'.$otp.'&'.$row->employee_id);
    $url = 'approval/cuti/tahunan/' . str_replace('=', '', $encoded);
		$teks_otp = "Kode OTP : *".intval($otp)."*";
		$message = whatsappMessage($employee_name, $pengajuan, '', $kd, $status, '');

		$this->send_wa($wa_no, $url, $message['subject'], $message['message'], $row->employee_id, $teks_otp);

		$data = [
      'approval2_st' => 1
    ];

		CutiHeader::find($row->id)->update($data);

		$result = [
			'message' => 'sukses'
		];

		return $result;
	}

	public function reject($post)
	{
		$kd = $post['kd'];
		$approval = $post['approval'];

		$row = CutiHeader::where('kd',$kd)->first();

		$data = [
			'periksa_st' => 0,
			'approval1_st' => 0,
      'approval2_st' => 0,
			'approval' => 2,
			'reject_id' => $approval,
			'reject_excuse' => $post['reject_excuse']
    ];

    CutiHeader::find($row->id)->update($data);

		$data_lines = [
      'approval_st' => 0
    ];

    CutiLines::where('cuti_header_id',$row->id)->update($data_lines);

		$reject_user = User::find($approval);

		$employee_name = $row->employee->name;
		$approval_name = $reject_user->name;

		$wa_no = $row->employee->no_hp;
		$pengajuan = 'Cuti Tahunan';
		$status = 'reject';
		$otp = $this->random_number();
		$encoded = base64_encode(time().'&'.$kd.'&'.$otp);
    $url = 'approval/cuti/tahunan/' . str_replace('=', '', $encoded);
		$teks_otp = "Kode OTP : *".intval($otp)."*";
		$message = whatsappMessage($employee_name, $pengajuan, $approval_name, $kd, $status, $post['reject_excuse']);

		$this->send_wa($wa_no, $url, $message['subject'], $message['message'], $row->employee_id, $teks_otp);

    $response = [
			'message' => 'sukses'
		];

		return $response;
	}

	public function reject_wa($approval)
	{
		// $cuti_id = $post['cuti_id'];
		// $kd = $post['kd'];
		// $approval = $post['approval'];

		// $row = CutiHeader::find($cuti_id);

		// $data2 = [
		// 	'periksa_st' => 0,
		// 	'approval1_st' => 0,
    //   'approval2_st' => 0,
		// 	'approval' => 2,
		// 	'reject_id' => $approval,
		// 	'reject_excuse' => $post['reject_excuse']
    // ];

		// // dd($data);

    // CutiHeader::find($cuti_id)->update($data2);

		// $data_lines = [
    //   'approval_st' => 0
    // ];

    // CutiLines::where('cuti_header_id',$cuti_id)->update($data_lines);

		$reject_user = User::find($approval);

		$employee_name = $row->employee->name;
		$approval_name = $reject_user->name;

		$wa_no = $row->employee->no_hp;
		$pengajuan = 'Cuti Tahunan';
		$status = 'reject';
		$otp = $this->random_number();
		$encoded = base64_encode(time().'&'.$kd.'&'.$otp);
    $url = 'approval/cuti/tahunan/' . str_replace('=', '', $encoded);
		$teks_otp = "Kode OTP : *".intval($otp)."*";
		$message = whatsappMessage($employee_name, $pengajuan, $approval_name, $kd, $status, $post['reject_excuse']);

		$this->send_wa($wa_no, $url, $message['subject'], $message['message'], $row->employee_id, $teks_otp);

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

		return whatsappMonitor($no_wa, $teks_tengah, $new_message, $subject, $send_wa['status'], $send_wa['message'], $users_id);
	}

	public function random_number()
	{
		return substr(number_format(time() * rand(1111,9999),0,'',''),0,4);
	}
}