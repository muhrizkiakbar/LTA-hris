<?php

namespace App\Services\Employee;

use App\Models\AppraisalScore;
use App\Models\Employee;
use App\Models\Konseling;
use App\Models\ResignInterview;
use App\Models\ResignInterviewKey;
use App\Models\ResignInterviewScore;
use App\Models\SuratPeringatan;
use App\Models\User;
use App\Models\UserLokasi;
use App\Models\Vaksin;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeServices
{
	public function getData()
	{
		$row = [];
		$users_id = auth()->user()->id;
    $role = auth()->user()->role_id;

		$cek_bawahan = getBawahan();

		if ($role==1 || $role==2 || $role==3) 
		{
			$row = Employee::where('role_id',5)
								 ->whereNull('resign_st')
								 ->get();
		}
		else if ($role==4 || $role==11) 
		{
			$get_lokasi = UserLokasi::where('users_id', $users_id)->pluck('lokasi_id');
			$row = Employee::where('role_id',5)
										->whereNull('resign_st')
										->whereIn('lokasi_id', $get_lokasi)
										->get();

		}
		else if ($role==5)
		{
			if (auth()->user()->department_id==1 && auth()->user()->jabatan_id == 3) 
			{
				$row = Employee::where('role_id',5)
											->whereNull('resign_st')
											->get();
			}
			else if (auth()->user()->jabatan_id == 3)
			{
				$row = Employee::where('role_id',5)
								 ->whereNull('resign_st')
								 ->where('atasan_id', $users_id)
								 ->get();
			}
		}

		return $row;
	}

	public function getDataResign()
	{
		$row = [];
		$users_id = auth()->user()->id;
    $role = auth()->user()->role_id;

		$cek_bawahan = getBawahan();

		if ($role==1 || $role==2 || $role==3) 
		{
			$row = Employee::where('role_id',5)
										->where('resign_st',1)
										->orderBy('resign_date','DESC')
										->get();
		}
		else if ($role==4 || $role==11) 
		{
			$get_lokasi = UserLokasi::where('users_id', $users_id)->pluck('lokasi_id');
			$row = Employee::where('role_id',5)
										->where('resign_st',1)
										->whereIn('lokasi_id', $get_lokasi)
										->orderBy('resign_date','DESC')
										->get();

		}
		else if ($role==5)
		{
			if (auth()->user()->department_id==1 && auth()->user()->jabatan_id == 3) 
			{
				$row = Employee::where('role_id',5)
										->where('resign_st',1)
										->orderBy('resign_date','DESC')
										->get();
			}
			else
			{
				if (count($cek_bawahan) > 0) 
				{
					$row = Employee::where('role_id',5)
									->where('resign_st',1)
									->where('atasan_id', $users_id)
									->orderBy('resign_date','DESC')
									->get();
				}
			}
			
		}

		return $row;
	}

	public function detail($id)
	{
		$get = Employee::find($id);
		$join_date = $get->join_date;

		$saldo_cuti = get_saldo_cuti($id, $join_date, "now");

		$vaksin = Vaksin::where('users_id',$id)
										->orderBy('id','DESC')
										->get();

		$konseling = Konseling::where('users_id',$id)
													->orderBy('id','DESC')
													->get();

		$surat_peringatan = SuratPeringatan::where('users_id',$id)
																			->orderBy('id','DESC')
																			->get();

		$appraisal = AppraisalScore::where('users_id',$id)->orderBy('id','DESC');

		$absensi_yearly = $this->absensi_yearly($id);

		$data = [
			'get' => $get,
			'saldo_cuti' => $saldo_cuti,
			'vaksin' => $vaksin,
			'konseling' => $konseling,
			'surat_peringatan' => $surat_peringatan,
			'appraisal' => $appraisal,
			'absensi_yearly' => $absensi_yearly
		];

		return $data;
	}

	public function absensi_yearly($id)
	{
		$currentMonth = (int)date('n');  // Mendapatkan bulan saat ini sebagai angka (1-12)

		$year = date('Y');

		$data = [];

		for ($month = 1; $month <= $currentMonth; $month++) 
		{
			$dateTime = new DateTime("$year-$month-01");
			
			$data[] = [
				'periode' =>$dateTime->format('F'),
				'monthly_sakit' => $this->absensi_monthly($id, $month, $year, 'S'),
				'monthly_izin' => $this->absensi_monthly($id, $month, $year, 'I'),
				'monthly_alpa' => $this->absensi_monthly($id, $month, $year, 'A')
			];
		}

		return $data;
	}

	public function absensi_monthly($id, $month, $year, $label)
	{
		$get = DB::table('view_absensi_yearly')
						 ->where('users_id',$id)
						 ->whereMonth('date',$month)
						 ->whereYear('date',$year)
						 ->where('label',$label)
						 ->sum('active');

		$sum = $get != 0 ? $get : 0;

		return $sum;
	}

	public function reset_password($id)
	{
		$get = User::find($id);

		$data = [
			'password' => Hash::make($get->nik)
		];

		return User::find($id)->update($data);
	}

	function resign_interview($post)
	{
		if (isset($post['check_bypass']) || $post['check_bypass']==1) 
		{
			$data = [
				'resign_date' => $post['resign_date'],
				'resign_types_id' => $post['resign_types_id'],
				'resign_reason' => $post['resign_reason'],
				'resign_statuses_id' => 1,
				'resign_st' => 1,
				'resign_interview_st' => 1,
				'resign_clearance_st' => 1
			];
	
			Employee::find($post['id'])->update($data);
		}
		else
		{
			$data = [
				'resign_date' => $post['resign_date'],
				'resign_types_id' => $post['resign_types_id'],
				'resign_reason' => $post['resign_reason'],
				'resign_statuses_id' => 2,
				'resign_st' => 1
			];
	
			Employee::find($post['id'])->update($data);
			$this->generate_resign_interview($post['id']);
	
			$user = Employee::find($post['id']);
	
			// $wa_no = '085250038002';
			$wa_no = $user->no_hp;
			$pengajuan = 'Resign Interview';
			$status = 'resign_interview';
			$otp = $this->random_number();
			$encoded = base64_encode(time().'&'.$post['id'].'&'.$otp);
			$url = 'resign/interview/' . str_replace('=', '', $encoded);
			$teks_otp = "Kode OTP : *".intval($otp)."*";
			$message = whatsappMessage($user->name, $pengajuan, '', $post['id'], $status, '');
	
			$this->send_wa($wa_no, $url, $message['subject'], $message['message'], $post['id'], $teks_otp);
		}
		
	}

	public function interview_score($users_id)
	{
		$data = [];

		$row = ResignInterviewScore::where('users_id',$users_id)
															 ->orderBy('resign_interviews_id','ASC')
															 ->get();

		foreach ($row as $value) 
		{
			$data[] = [
				'id' => $value->id,
				'title' => $value->resign_interview->title,
				'key_title' => $value->resign_interview->key,
				'key' => $this->interview_score_key($value->resign_interviews_id)
			];
		}

		return $data;
	}

	public function interview_score_key($id)
	{
		$data = [];

		$row = ResignInterviewKey::where('resign_interviews_id',$id)->get();

		foreach ($row as $value) 
		{
			$data[] = [
				'id' => $value->id,
				'title' => $value->title,
			];
		}

		return $data;
	}

	public function generate_resign_interview($users_id)
	{
		$interview = ResignInterview::get();

		$cek = ResignInterviewScore::where('users_id',$users_id)->get();

		if (count($cek) == 0) 
		{
			foreach ($interview as $value) 
			{
				$data[] = [
					'users_id' => $users_id,
					'resign_interviews_id' => $value->id
				];
			}

			ResignInterviewScore::insert($data);
		}
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

	public function report_karyawan($data)
	{
		$users_id = auth()->user()->id;
		$role = auth()->user()->role_id;

		if ($data['lokasi']=='') 
		{
			if ($role==4 || $role==11) 
			{
				$get_lokasi = UserLokasi::where('users_id', $users_id)->pluck('lokasi_id');
				$row = User::where('department_id',$data['department'])
									 ->whereIn('lokasi_id',$get_lokasi)
									 ->where('resign_st',NULL)
									 ->where('role_id',5)
									 ->orderBy('jabatan_id','ASC')
									 ->orderBy('nik','ASC')
									 ->get();
			}
			else
			{
				$row = User::where('department_id',$data['department'])
									 ->where('resign_st',NULL)
									 ->where('role_id',5)
									 ->orderBy('jabatan_id','ASC')
									 ->orderBy('nik','ASC')
									 ->get();
			}
		}
		else
		{
			$row = User::where('department_id',$data['department'])
								 ->where('lokasi_id',$data['lokasi'])
								 ->where('resign_st',NULL)
								 ->where('role_id',5)
								 ->orderBy('jabatan_id','ASC')
								 ->orderBy('nik','ASC')
								 ->get();
		}
		
		return $row;
	}

	public function export($tipe)
	{
		$row = $this->export_view($tipe);

		$collection = collect($row);

		return $collection;
	}

	public function export_view($tipe)
	{
		$data = [];

		$users_id = auth()->user()->id;
		$role = auth()->user()->role_id;
		
		if ($role==4 || $role==11) 
		{
			$get_lokasi = UserLokasi::where('users_id', $users_id)->pluck('lokasi_id');

			if ($tipe=='all') 
			{
				$row = Employee::whereIn('lokasi_id',$get_lokasi)
										->where('role_id',5)
										->orderBy('jabatan_id','ASC')
										->orderBy('nik','ASC')
										->get();
			}
			else if ($tipe=='active') 
			{
				$row = Employee::whereIn('lokasi_id',$get_lokasi)
										->where('resign_st',NULL)
										->where('role_id',5)
										->orderBy('jabatan_id','ASC')
										->orderBy('nik','ASC')
										->get();
			}
			else
			{
				$row = Employee::whereIn('lokasi_id',$get_lokasi)
										->where('resign_st',1)
										->where('role_id',5)
										->orderBy('jabatan_id','ASC')
										->orderBy('nik','ASC')
										->get();
			}
		}
		else
		{
			if ($tipe=='all') 
			{
				$row = Employee::where('role_id',5)
										->orderBy('jabatan_id','ASC')
										->orderBy('nik','ASC')
										->get();
			}
			else if ($tipe=='active') 
			{
				$row = Employee::where('resign_st',NULL)
										->where('role_id',5)
										->orderBy('jabatan_id','ASC')
										->orderBy('nik','ASC')
										->get();
			}
			else
			{
				$row = Employee::where('resign_st',1)
										->where('role_id',5)
										->orderBy('jabatan_id','ASC')
										->orderBy('nik','ASC')
										->get();
			}
		}

		foreach ($row as $item) 
		{
			$data[] = [
				'NIK' => $item->nik,
				'Nama' => $item->name,
				'Distrik' => isset($item->distrik_id) ? $item->distrik->title : '',
				'Lokasi Kerja' => isset($item->lokasi_id) ? $item->lokasi : '',
				'Department' => isset($item->department_id) ? $item->department->title : '',
				'Level Jabatan' => isset($item->jabatan_id) ? isset($item->lvl) ? $item->lvl->title : '' : '', 
				'Jabatan' => isset($item->department_jabatan_id) ? isset($item->jabatan) ? $item->jabatan->title : '' : '',
				'Atasan Langsung' => isset($item->atasan) ? $item->atasan->name : '',
				'Email Kantor' => $item->email,
				'Email Pribadi' => $item->email_kantor,
				'No HP' => isset($item->no_hp) ? strval($item->no_hp) : '' ,
				'Nomor KTP' => isset($item->ktp_no) ? strval($item->ktp_no) : '',
				'Nomor NPWP' => isset($item->npwp_no) ? replace_npwp($item->npwp_no) : '',
				'Tempat Lahir' => $item->tempat_lahir,
        'Tanggal Lahir' => Carbon::parse($item->tgl_lahir)->format('d/m/Y'),
				'Jenis Kelamin' => isset($item->gender_id) ? $item->gender->title : '',
        'Status Perkawinan' => isset($item->marriage_id) ? $item->marriage->title : '',
				'Tanggal Bergabung' => Carbon::parse($item->join_date)->format('d/m/Y'),
				'Lama Bekerja' => time_elapsed_string2(date("Y-m-d H:i:s",strtotime($item->join_date)),true),
				'Perusahaan' => isset($item->perusahaan_id) ? $item->perusahaan->title : '',
				'Nomor BPJS Kesehatan' => strval($item->bpjs),
				'Nomor BPJS TK' => strval($item->bpjstk),
				'Alamat KTP' => $item->alamat,
				'Alamat Domisili' => $item->alamat_lain,
				'Kode Pos' => $item->kodepos,
				'Sloting' => isset($item->sloting) ? $item->sloting->kd : '',
				'Status Kontrak' => isset($item->kontrak) ? $item->kontrak->employee_sts->title : '',
				'Tanggal Berakhir Kontrak' => isset($item->kontrak) ? ($item->kontrak->employee_sts_id=='4') ? '' : $item->kontrak->tgl_end : '' ,
				'Bank' => isset($item->bank) ? $item->bank->title : '',
				'Nomor Rekening' => strval($item->no_rek),
				'Principle' => isset($item->divisi_id) ? isset($item->divisi) ? $item->divisi->title : '' : '',
				'Sales Code SAP' => $item->sales_code,
				'Pendidikan Terakhir' => isset($item->ijazah_detail) ? $item->ijazah_detail->title : '',
				'Institusi' => $item->ijazah_institusi,
				'Jurusan' => $item->ijazah_jurusan,
				'Golongan Darah' => isset($item->blood_id) ? $item->blood->title : '',
				'PTKP' => isset($item->ptkp_id) ? $item->ptkp_detail->title : '',
				'Ibu Kandung' => $item->ibu_kandung,
				'Tanggal Resign' => isset($item->resign_st) ? Carbon::parse($item->resign_date)->format('d/m/Y') : '-',
				'Alasan' => isset($item->resign_st) ? $item->resign_reason : '-',
				'Claim Principal' => isset($item->claim_principal) ? $item->claim_principal->title : '-',
				'Jumlah Family Lain' => isset($item->family_lain) ? $item->family_lain : 0
			];
		}

		return $data;
	}
}