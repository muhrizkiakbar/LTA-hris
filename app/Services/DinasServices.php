<?php

namespace App\Services;

use App\Models\Cabang;
use App\Models\Dinas;
use App\Models\DinasBiayaTol;
use App\Models\DinasKendaraan;
use App\Models\DinasLines;
use App\Models\DinasLinesKendaraan;
use App\Models\DinasLokasiJarak;
use App\Models\DinasTempKendaraan;
use App\Models\DinasTipe;
use App\Models\DinasUang;
use App\Models\DinasUangExcept;
use App\Models\Lokasi;
use App\Models\User;
use App\Models\UserLokasi;
use GuzzleHttp\Psr7\Request;

class DinasServices 
{
	public function data()
	{
		$role = auth()->user()->role_id;
    $users_id = auth()->user()->id;

		$year = date('Y')-1;

    if ($role == 1 || $role == 2 || $role == 3) 
		{
      $get = Dinas::whereYear('date','>=',$year)
									->orderBy('id','DESC')
									->get();
    } 
		elseif($role==10)
		{
			$user_lokasi = UserLokasi::where('users_id', $users_id)->pluck('lokasi_id');
      $get = Dinas::where('status',1)
									->whereIn('dinas_payment_id',[1,2,3])
									->whereYear('date','>=',$year)
									->whereIn('lokasi_id',$user_lokasi)
									->orderBy('id','DESC')
									->get();
		}
		else 
		{
      $user_lokasi = UserLokasi::where('users_id', $users_id)->pluck('lokasi_id');
      $get = Dinas::whereYear('date','>=',$year)
									->whereIn('lokasi_id',$user_lokasi)
									->orderBy('id','DESC')
									->get();
    }

		return $get;
	}

	public function pluck_data()
	{
		$users_id = auth()->user()->id;
    $role = auth()->user()->role_id;

		if ($role==1 || $role==2 || $role==3) 
		{
			$user = User::where('role_id',5)
									->whereNull('resign_st')
									->orderBy('nik','ASC')
									->pluck('name', 'id');
		}
		else
		{
			$get_lokasi = UserLokasi::where('users_id', $users_id)->pluck('lokasi_id');
			$user = User::where('role_id',5)
									->whereNull('resign_st')
									->whereIn('lokasi_id', $get_lokasi)
									->orderBy('nik','ASC')
									->pluck('name', 'id');
		}

		$atasan = User::whereIn('role_id', [2,5])
                  ->whereNull('resign_st')
									->whereNotIn('id',[10637])
                  ->orderBy('role_id','ASC')
                  ->pluck('name', 'id');

		$cabang = Cabang::pluck('title','id');
		$tipe = DinasTipe::pluck('title','id');
		$kendaraan = DinasKendaraan::pluck('title','id');

		$lokasi = Lokasi::pluck('title','id');

    $bool = [
      '1' => 'Ya',
      '2' => 'Tidak'
    ];

		$bool2 = [
      '1' => 'Ya',
      '2' => 'Tidak',
			'3' => 'Penyesuaian'
    ];

		$result = [
			'user' => $user,
			'atasan' => $atasan,
			'cabang' => $cabang,
			'tipe' => $tipe,
			'kendaraan' => $kendaraan,
			'lokasi' => $lokasi,
			'bool' => $bool,
			'bool2' => $bool2
		];

		return $result;
	}

	public function kendaraan_view()
	{
		$users_id = auth()->user()->id;

		$row = DinasTempKendaraan::where('users_id',$users_id)
														 ->get();

		return $row;
	}

	public function kendaraan_store($post)
	{
		$sharing_kendaraan = $post['sharing_kendaraan'];

		$dinas_kendaraan = $post['dinas_kendaraan_id'];  
    $kendaraan = DinasKendaraan::find($dinas_kendaraan);
    $km = $kendaraan->km;
    $bbm = $kendaraan->harga_bbm;

		$lokasi_asal_id = $post['lokasi_asal_id'];
    $lokasi_tujuan_id = $post['lokasi_tujuan_id'];
    $jarak = $post['jarak'];
    $pp = $post['pp'];
    $pp_tol = $post['pp_tol'];

		$get_jarak = DinasLokasiJarak ::where('lokasi_asal_id',$lokasi_asal_id)
                                  ->where('lokasi_tujuan_id',$lokasi_tujuan_id)
                                  ->get();

		if($dinas_kendaraan==1 || $dinas_kendaraan==2)
		{
			if(count($get_jarak)==0)
			{
				$data_jarak = [
					'lokasi_asal_id' => $lokasi_asal_id,
					'lokasi_tujuan_id' => $lokasi_tujuan_id,
					'jarak' => $post['jarak']
				];

				// dd($data_jarak);

				DinasLokasiJarak::create($data_jarak);
			}   
		}	
		
		$dinas_biaya_tol = $post['dinas_biaya_tol_id'];

		if(!empty($dinas_biaya_tol))
    {
      $get_tol = DinasBiayaTol::find($dinas_biaya_tol);
      $dinas_biaya_tol_harga = $get_tol->biaya; 
    }
    else
    {
      $dinas_biaya_tol = 0;
      $dinas_biaya_tol_harga = 0;
      $biaya_tol = 0;
    }

    if($sharing_kendaraan==1)
    {
      $total_jarak = $jarak;
      $pemakaian_bbm = 0;
      $estimasi_harga = 0;
      $bbm = 0;
      $total_harga = 0;
      $biaya_tol = 0;
    }
    else
    {
      if($dinas_kendaraan==1 || $dinas_kendaraan==2)
      {
        if($pp==1)
        {
          $total_jarak = $jarak * 2;
          
        }
        else
        {
          $total_jarak = $jarak;
         
        }

        if($pp_tol==1)
        {
          $biaya_tol = $dinas_biaya_tol_harga * 2;
        }
        else
        {
          $biaya_tol = $dinas_biaya_tol_harga;
        }

        $pemakaian_bbm = $total_jarak / $km;
        $total_hargax = $pemakaian_bbm * $bbm;
        $estimasi_harga = round($total_hargax,0);
        $total_harga = $estimasi_harga+$biaya_tol;
      }
      else
      {
        if($dinas_kendaraan==5)
        {
          if($post['ppx']==1)
          {
            $estimasi_harga = $post['estimasi_harga'] * 2;
            $pp = 1;
          }
          else
          {
            $estimasi_harga = $post['estimasi_harga'];
            $pp = 0;
          }

          $total_jarak = $jarak;
        }
        else
        {
          $estimasi_harga = $post['estimasi_harga'];
          if(empty($jarak))
          {
            $total_jarak = 0;
          }
          else
          {
            $total_jarak = $jarak;
          } 
        }
        
        $biaya_tol = 0;
        
        $pemakaian_bbm = 0;
        $bbm = 0;
        $total_harga = $estimasi_harga;
      }
    }

    $data = [
      'dinas_kendaraan_id' => $dinas_kendaraan,
      'users_id' => $post['users_id'],
      'lokasi_asal_id' => $lokasi_asal_id,
      'lokasi_tujuan_id' => $lokasi_tujuan_id,
      'jarak' => $total_jarak,
      'pemakaian_bbm' => round($pemakaian_bbm,2),
      'harga_bbm' => $bbm,
      'estimasi_harga' => $estimasi_harga,
      'sharing_kendaraan' => $sharing_kendaraan,
      'dinas_biaya_tol_id' => $dinas_biaya_tol,
      'dinas_biaya_tol_harga' => $biaya_tol,
      'total_harga' => round($total_harga,2),
      'twoway' => $pp,
      'twoway_tol' => $pp_tol
    ];

    return DinasTempKendaraan::create($data);
	}

	public function store($post)
	{
		$users_id = auth()->user()->id;
    $name = auth()->user()->email;
    $menu = "Perjalanan Dinas";

    $kd = 'PD-' . time();

		$sharing = $post['sharing_room'];
		$uang_makanx = $post['uang_makan'];
		$daily_transport = $post['daily_transport'];

		$lokasi_tujuan = $post['lokasi_tujuan_id'];

		$employee = $post['users_id'];
    $getemployee = User::find($employee);
    $employee_name = $getemployee->name;
    $lokasi = $getemployee->lokasi_id;
    $department_id = $getemployee->department_id;
    $divisi_id = $getemployee->divisi_id;
    $jabatan_id = $getemployee->jabatan_id;
    $department_jabatan_id = $getemployee->department_jabatan_id;

		$periksa = $post['periksa_id'];
		$approval1 = $post['approval1_id'];
		$approval2 = $post['approval2_id'];

		$get_hr = User::find($periksa);
    $user_hr = $get_hr->users_id;
    $no_hr = $get_hr->no_hp;
    $approval_name = $get_hr->name;

		$cek_kendaraan = DinasTempKendaraan::where('users_id',$users_id)->get();

		$lokasi_detail = Lokasi::find($lokasi_tujuan);

		if (count($cek_kendaraan) == 0) 
		{
			$result = [
				'message' => 'empty_kendaraan'
			];
		}
		else
		{
			$tgl1 = strtotime($post['date_start']);
			$tgl2 = strtotime($post['date_end']);

			$durasi = [];

			for($i=$tgl1; $i<=$tgl2; $i += (60 * 60 * 24))
			{
				$durasi[] = $i;
			}

			$hari_dinas = count($durasi);

			$cek = DinasUangExcept::where('department_id',$department_id)
														->where('jabatan_id',$jabatan_id)
														->where('lokasi_asal_id',$lokasi)
														->where('lokasi_tujuan_id',$lokasi_tujuan);

			if (count($cek->get()) == 0) 
			{
				$dinas_uang = DinasUang::where('jabatan_id',$jabatan_id)->first();
			}
			else
			{
				$dinas_uang = $cek->first();
			}

			if ($uang_makanx==1) 
			{
				$uang_makan = $hari_dinas * $dinas_uang->uang_makan;
			}
			elseif($uang_makanx==3)
			{
				$uang_makan = $hari_dinas * $lokasi_detail->uang_makan;
			}
			else
			{
				$uang_makan = 0;
			}

			if($hari_dinas > 1)
			{
				if($sharing==1)
				{
					$uang_hotel = 0;
				}
				else
				{
					if ($lokasi_tujuan==2) 
					{
						$uang_hotel = 0;
					}
					else
					{
						$uang_hotel = ($hari_dinas - 1) * $dinas_uang->uang_hotel;
					}
					
				}
			}
			else
			{
				if($sharing==1)
				{
					$uang_hotel = 0;
				}
				else
				{
					if ($lokasi_tujuan==2) 
					{
						$uang_hotel = 0;
					}
					else
					{
						$uang_hotel = $hari_dinas * $dinas_uang->uang_hotel;
					}
					
				}
			}
			
			if(empty($department_id) && empty($divisi_id))
			{
				$result = [
					'message' => 'empty_department'
				];
			}
			else
			{
				$data = [
					'kd' => $kd,
					'users_id' => $post['users_id'],
					'date' => date('Y-m-d'),
					'date_start' => $post['date_start'],
					'date_end' => $post['date_end'],
					'lama_dinas' => $hari_dinas,
					'dinas_tipe_id' => $post['dinas_tipe_id'],
					'desc' => $post['keperluan'],
					'uang_makan' => $uang_makan,
					'uang_hotel' => $uang_hotel,
					'lokasi_id' => $lokasi,
					'department_id' => $department_id,
					'jabatan_id' => $jabatan_id,
					'department_jabatan_id' => $department_jabatan_id,
					'divisi_id' => $divisi_id,
					'periksa_id' => $periksa,
					'approval1_id' => $approval1,
					'approval2_id' => $approval2,
					'catatan' => $post['catatan']
				];

				$post2 = Dinas::create($data);

				if($post2)
				{
					$total_kendaraan = 0;
					$temp_kendaraan = DinasTempKendaraan::where('users_id',$users_id)->get();
					foreach($temp_kendaraan as $temp2)
					{
						$dinas_kendaraan2 = $temp2->dinas_kendaraan_id;
						$sharing_kendaraan2 = $temp2->sharing_kendaraan;
						$harga2 = $temp2->total_harga;

						$kendaraan2 = DinasKendaraan::find($dinas_kendaraan2);
						$km2 = $kendaraan2->km;
						$harga_bbm2 = $kendaraan2->harga_bbm;
						

						if($sharing_kendaraan2==1)
						{
							$total_jarak2 = 0;
							$estimasi_harga2 = 0;
							$jarak_toleransi = 0;
							$pemakaian_bbm2 = 0;
							$estimasi_harga_bbm = 0;
						}
						else
						{
							if($dinas_kendaraan2==1 || $dinas_kendaraan2==2)
							{
								if ($daily_transport==1) 
								{
									$jarak_toleransi = 0;
									$pemakaian_bbm2 =0;

									$total_jarak2 = $temp2->jarak * $hari_dinas;
									$estimasi_harga_bbm = ($total_jarak2 / $km2) * $harga_bbm2;
									$estimasi_harga2 = $estimasi_harga_bbm + $temp2->dinas_biaya_tol_harga;
								}
								else
								{
									$jarak_toleransi = $hari_dinas * 20;
									$pemakaian_bbm2 = ($jarak_toleransi / $km2) + $temp2->pemakaian_bbm;
									$estimasi_harga_bbm2 = $pemakaian_bbm2 * $harga_bbm2;

									$total_jarak2 = $temp2->jarak;
									$estimasi_harga_bbm = $estimasi_harga_bbm2;
									$estimasi_harga2 = $estimasi_harga_bbm + $temp2->dinas_biaya_tol_harga;
								}
								
							}
							else
							{
								$pemakaian_bbm2 = 0;
								$total_jarak2 = 0;
								$estimasi_harga2 = $harga2;
								$jarak_toleransi = 0;
								$estimasi_harga_bbm = 0;
							}
						}

						$total_kendaraan += $estimasi_harga2;

						$lines[] = [
							'dinas_id' => $post2->id,
							'dinas_kendaraan_id' => $dinas_kendaraan2,
							'jarak' => $total_jarak2,
							'jarak_toleransi' => $jarak_toleransi,
							'estimasi_harga' => $estimasi_harga_bbm,
							'sharing_kendaraan' => $sharing_kendaraan2,
							'lokasi_asal_id' => $temp2->lokasi_asal_id,
							'lokasi_tujuan_id' => $temp2->lokasi_tujuan_id,
							'dinas_biaya_tol_id' => $temp2->dinas_biaya_tol_id,
							'dinas_biaya_tol_harga' => $temp2->dinas_biaya_tol_harga,
							'pemakaian_bbm' => round($pemakaian_bbm2,2),
							'total_harga' => $estimasi_harga2,
							'twoway' => $temp2->twoway,
							'twoway_tol' => $temp2->twoway_tol
						];
					}

					// dd($lines);

					$grand_harga = 0;
					$grand_harga = $total_kendaraan + $uang_hotel + $uang_makan;

					$data_harga = [
						'estimasi_harga' => $total_kendaraan,
						'total_harga' => $grand_harga,
					];

					$post_lines = DinasLinesKendaraan::insert($lines);
					if($post_lines)
					{
						Dinas::find($post2->id)->update($data_harga);
						DinasTempKendaraan::where('users_id',$users_id)->delete();
					}

					$date_start = $post['date_start'];
					$date_from = date ("Y-m-d", strtotime("-1 day", strtotime($date_start)));
					$date_end = $post['date_end'];
					while (strtotime($date_from) < strtotime($date_end)) 
					{
						$date_from = date ("Y-m-d", strtotime("+1 day", strtotime($date_from)));//looping tambah 1 date
						$data2 = [
							'dinas_id' => $post2->id,
							'users_id' => $post['users_id'],
							'date' => $date_from,
							'status' => 0
						];

						DinasLines::create($data2);
					}
				}

				// $no_wa = '085250038002';
				$no_wa = $no_hr;
				$pengajuan = 'Perjalanan Dinas';
				$status = 'periksa';
				$otp = $this->random_number();
				$encoded = base64_encode(time().'&'.$kd.'&'.$otp.'&'.$periksa.'&'.$status);
				$url = 'approval/dinas/' . str_replace('=', '', $encoded);
				$teks_otp = "Kode OTP : *".intval($otp)."*";
				$message = whatsappMessage($employee_name, $pengajuan, $approval_name, $kd, $status, '');

				$this->send_wa($no_wa, $url, $message['subject'], $message['message'], $employee, $teks_otp);

				$title = $name;
				$action = '<badge class="badge badge-danger">INSERT DATA</badge>';
				$keterangan = "Insert data dari menu <b>" . $menu . "</b> tanggal : <b>" . date('Y-m-d') . "</b> , By : <b>" . $name . "</b>";
		
				history($title, $action, $keterangan);

				$result = [
					'message' => 'sukses',
					'dinas_id' => $kd,
				];
			}
		}

		return $result;
	}

	public function detail($kd)
	{
		$dinas = Dinas::where('kd',$kd)->first();

		$header = Dinas::find($dinas->id);
		$lines = DinasLinesKendaraan::where('dinas_id',$header->id)->get();

		$data = [
			'header' => $header,
			'lines' => $lines
		];

		return $data;
	}

	public function delete($id)
	{
		Dinas::find($id)->delete();
		DinasLines::where('dinas_id',$id)->delete();
		DinasLinesKendaraan::where('dinas_id',$id)->delete();
	}

	public function periksa($code)
	{
		$url_decode = base64_decode($code);
    $exp = explode('&',$url_decode);

		$kd = $exp[1];

		$row = Dinas::where('kd',$kd)->first();

		$approval = User::find($row->approval1_id);

		$data = [
      'periksa_st' => 1
    ];

    Dinas::where('id',$row->id)->update($data);

		$employee_name = $row->employee->name;
		$approval_name = $approval->name;
		$approval_hp = $approval->no_hp;

		$wa_no = $approval_hp;
		$pengajuan = 'Perjalanan Dinas';
		$status = 'approval1';
		$otp = $this->random_number();
		$encoded = base64_encode(time().'&'.$kd.'&'.$otp.'&'.$row->approval1_id.'&'.$status);
    $url = 'approval/dinas/' . str_replace('=', '', $encoded);
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

		$row = Dinas::where('kd',$kd)->first();

		$approval = User::find($row->approval2_id);

		
		$employee_name = $row->employee->name;
		$approval_name = $approval->name;
		$approval_hp = $approval->no_hp;

		$wa_no = $approval_hp;
		$pengajuan = 'Perjalanan Dinas';
		$status = 'approval2';
		$otp = $this->random_number();
		$encoded = base64_encode(time().'&'.$kd.'&'.$otp.'&'.$row->approval2_id.'&'.$status);
    $url = 'approval/dinas/' . str_replace('=', '', $encoded);
		$teks_otp = "Kode OTP : *".intval($otp)."*";
		$message = whatsappMessage($employee_name, $pengajuan, $approval_name, $kd, $status, '');

		$this->send_wa($wa_no, $url, $message['subject'], $message['message'], $row->users_id, $teks_otp);

		$data = [
			'approval1_st' => 1,
      'status' => 1,
			'dinas_payment_id' => 1
    ];

		$data2 = [
      'status' => 1
    ];

		Dinas::find($row->id)->update($data);
    DinasLines::where('dinas_id', $row->id)->update($data2);

		$result = [
			'message' => 'sukses'
		];

		return $result;
	}

	public function ketahui($code)
	{
		$url_decode = base64_decode($code);
    $exp = explode('&',$url_decode);

		$kd = $exp[1];

		$row = Dinas::where('kd',$kd)->first();

		$employee_name = $row->employee->name;

		$wa_no = $row->employee->no_hp;
		$pengajuan = 'Perjalanan Dinas';
		$status = 'approve';
		$otp = $this->random_number();
		$encoded = base64_encode(time().'&'.$kd.'&'.$otp.'&'.$row->users_id);
    $url = 'approval/dinas/' . str_replace('=', '', $encoded);
		$teks_otp = "Kode OTP : *".intval($otp)."*";
		$message = whatsappMessage($employee_name, $pengajuan, '', $kd, $status, '');

		$this->send_wa($wa_no, $url, $message['subject'], $message['message'], $row->users_id, $teks_otp);

		$data = [
      'approval2_st' => 1
    ];

		Dinas::find($row->id)->update($data);

		$result = [
			'message' => 'sukses'
		];

		return $result;
	}

	public function ketahui_trf($code)
	{
		$url_decode = base64_decode($code);
    $exp = explode('&',$url_decode);

		$kd = $exp[1];

		$row = Dinas::where('kd',$kd)->first();

		$employee_name = $row->employee->name;

		$wa_no = $row->employee->no_hp;
		$pengajuan = 'Perjalanan Dinas';
		$status = 'approve';
		$otp = $this->random_number();
		$encoded = base64_encode(time().'&'.$kd.'&'.$otp.'&'.$row->users_id);
    $url = 'approval/dinas/' . str_replace('=', '', $encoded);
		$teks_otp = "Kode OTP : *".intval($otp)."*";
		$message = whatsappMessage($employee_name, $pengajuan, '', $kd, $status, '');

		$this->send_wa($wa_no, $url, $message['subject'], $message['message'], $row->users_id, $teks_otp);

		$data = [
      'approval2_st' => 1,
			'trf_date' => date('Y-m-d')
    ];

		Dinas::find($row->id)->update($data);

		$result = [
			'message' => 'sukses'
		];

		return $result;
	}

	public function reject($post)
	{
		$kd = $post['kd'];
		$approval = $post['approval'];

		$row = Dinas::where('kd',$kd)->first();

		$data = [
			'periksa_st' => 0,
			'approval1_st' => 0,
      'approval2_st' => 0,
			'status' => 2,
			'reject_id' => $approval,
			'reject_excuse' => $post['reject_excuse']
    ];

    Dinas::where('id',$row->id)->update($data);

		$data_lines = [
      'status' => 0
    ];

    DinasLines::where('dinas_id',$row->id)->update($data_lines);

		$reject_user = User::find($approval);

		$employee_name = $row->employee->name;
		$approval_name = $reject_user->name;

		$wa_no = $row->employee->no_hp;
		$pengajuan = 'Perjalanan Dinas';
		$status = 'reject';
		$otp = $this->random_number();
		$encoded = base64_encode(time().'&'.$kd.'&'.$otp);
    $url = 'approval/dinas/' . str_replace('=', '', $encoded);
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

	public function view_report_dinas($data)
	{
		$role = auth()->user()->role_id;
    $users_id = auth()->user()->id;
		$users_department = auth()->user()->department_id;

		$department = $data['department'];
    $lokasi = $data['lokasi'];
    $periode = $data['periode'];

		$date = explode(' - ',$periode);

		$date1 = date('Y-m-d',strtotime($date[0]));
    $date2 = date('Y-m-d',strtotime($date[1]));

		if (empty($department) && empty($lokasi)) 
		{
			if ($role == 1 || $role == 2 || $role == 3) 
			{
				$get = Dinas::where('date','>=',$date1)
										->where('date','<=',$date2)
										->where('status',1)
										->orderBy('date','ASC')
										->get();
			} 
			else
			{
				if ($users_department==1) 
				{
					$get = Dinas::where('date','>=',$date1)
										->where('date','<=',$date2)
										->where('status',1)
										->orderBy('date','ASC')
										->get();
				}
				else
				{
					$user_lokasi = UserLokasi::where('users_id', $users_id)->pluck('lokasi_id');
					$get = Dinas::whereIn('lokasi_id',$user_lokasi)
											->where('date','>=',$date1)
											->where('date','<=',$date2)
											->where('status',1)
											->orderBy('date','ASC')
											->get();
				}
			}
		}
		else if (empty($department) && !empty($lokasi)) 
		{
			$get = Dinas::where('lokasi_id',$lokasi)
									->where('date','>=',$date1)
									->where('date','<=',$date2)
									->where('status',1)
									->orderBy('date','ASC')
									->get();
		}
		else if (!empty($department) && empty($lokasi)) 
		{
			if ($role == 1 || $role == 2 || $role == 3) 
			{
				$get = Dinas::where('department_id',$department)
										->where('date','>=',$date1)
										->where('date','<=',$date2)
										->where('status',1)
										->orderBy('date','ASC')
										->get();
			}
			else
			{
				if ($users_department==1) 
				{
					$get = Dinas::where('department_id',$department)
										->where('date','>=',$date1)
										->where('date','<=',$date2)
										->where('status',1)
										->orderBy('date','ASC')
										->get();
				}
				else
				{
					$user_lokasi = UserLokasi::where('users_id', $users_id)->pluck('lokasi_id');
					$get = Dinas::where('department_id',$department)
											->whereIn('lokasi_id',$user_lokasi)
											->where('date','>=',$date1)
											->where('date','<=',$date2)
											->where('status',1)
											->orderBy('date','ASC')
											->get();
				}
			}
		}
		else
		{
			$get = Dinas::where('department_id',$department)
									->where('lokasi_id',$lokasi)
									->where('date','>=',$date1)
									->where('date','<=',$date2)
									->where('status',1)
									->orderBy('date','ASC')
									->get();
		}

		return $get;
	}
}