<?php

namespace App\Services\Absensi;

use App\Models\Absensi;
use App\Models\AbsensiIjinLines;
use App\Models\AbsensiRemarks;
use App\Models\Attendance;
use App\Models\AttendanceExcept;
use App\Models\CutiLines;
use App\Models\Department;
use App\Models\DinasLines;
use App\Models\Employee;
use App\Models\Lokasi;
use App\Models\SuratIjin;
use App\Models\User;
use App\Models\UserLokasi;
use DateTime;
use Illuminate\Support\Facades\DB;

class AbsensiServices
{
	public function data()
	{
		$users_id = auth()->user()->id;
    $role = auth()->user()->role_id;

		$year = date('Y');

		// dd($month);

		if ($role==1 || $role==2 || $role==3) 
		{
			$get = Absensi::whereYear('date',$year)
										->orderBy('id','DESC')
										->limit('1000')
										->get();
		}
		else
		{
			$get_lokasi = UserLokasi::where('users_id', $users_id)->pluck('lokasi_id');
			$get = Absensi::select('absensi.*')
										->leftJoin('users', 'absensi.nik', '=', 'users.nik')
										->whereYear('absensi.date',$year)
										->whereIn('users.lokasi_id',$get_lokasi)
										->orderBy('absensi.id','DESC')
										->limit('500')
										->get();
		}

		return $get;
	}

	public function import($excel, $mesin)
	{
		$insert = [];

		if($excel)
    {
			$input['imagename'] = 'absenlog_' . time() . '.' . $excel->extension();
      $path = public_path('/storage/upload/absen/');
      $excel->move($path, $input['imagename']);
      $files = $path.$input['imagename'];

      $fp = fopen($files, "r");
			$data = fread($fp, filesize($files));
			fclose($fp);

			if($mesin==7)
			{
				$output=explode("\n",$data);
			}
			else
			{
				$output=explode("\r\n",$data);
			}

			// dd($output);

      $filter = array_filter($output);

			// dd($filter);

      $chunk = $this->fill_chunck($filter,25);
      $insert = [];

			if ($mesin==1) 
      {
        $insert = $this->generate_absen_secure($filter);
      }
      else if($mesin==2)
      {
        $insert = $this->generate_absen_fingerspot($filter);
      }
      elseif($mesin==3)
      {
        $insert = $this->generate_absen_fingerspotV2($filter);
      }
      elseif($mesin==4)
      {
        $insert = $this->generate_absen_solution($filter);
      }
      elseif($mesin==5)
      {
        $insert = $this->generate_absen_fingerspotV3($filter);
      }
			elseif($mesin==6)
      {
        $insert = $this->generate_absen_fingerspotV4($filter);
      }
			elseif($mesin==7)
      {
        $insert = $this->generate_absen_solutionV2($filter);
      }
			else
			{
				$insert = $this->generate_manual($files);
			}

			// dd($insert);

			$count = count($insert);
      
      if($count < 1000)
      {
        $insert = collect($insert);
        $chunks = $insert->chunk(100);
      }
      else
      {
        $insert = collect($insert);
        $chunks = $insert->chunk(500);
      }

      foreach ($chunks as $chunk)
      {
        DB::table('absensi')->insert($chunk->toArray());
      }

			$response = [
				'message' => 'sukses'
			];
		}
		else
		{
			$response = [
				'message' => 'error'
			];
		}

		return $response;
	}

	public function generate_absen_secure($text)
	{
		foreach ($text as $value) 
		{
			$exp = explode(",",$value);

			$nik = $exp[1];
			$date = date('Y-m-d',strtotime($exp[3]));
			$time = date('H:i:s',strtotime($exp[4]));

			$data = [
				'nik' => $nik,
				'date' => $date,
				'time' => $time
			];
		
			$insert[] = $data;
		}

		return $insert;
	}

	public function generate_absen_fingerspot($text)
	{
		foreach ($text as $value) 
		{
			$exp = explode(",",$value);

			$nik = $exp[3];
			$date = date('Y-m-d',strtotime($exp[1]));
			$time = date('H:i:s',strtotime($exp[2]));

			if($nik=="PIN")
			{
				$data = [];
			}
			else
			{
				$data = [
					'nik' => $nik,
					'date' => $date,
					'time' => $time
				];
			}
		
			$insert[] = $data;
		}

		return array_filter($insert);
	}

	public function generate_absen_fingerspotV2($text)
	{
		foreach ($text as $value) 
		{
			$exp = explode(",",$value);

			$nik = $exp[1];

			if($nik=="NIK" || empty($nik))
			{
				$data = [];
			}
			else
			{
				$date = convert_date($exp[3]);
				$time = date('H:i:s',strtotime($exp[4]));

				$data = [
					'nik' => $nik,
					'date' => $date,
					'time' => $time
				];
			}
		
			$insert[] = $data;
		}

		return array_filter($insert);
	}

	public function generate_absen_fingerspotV3($text)
	{
		foreach ($text as $value) 
		{
			$exp = explode(",",$value);

			$nik = $exp[1];

			if($nik=="NIP" || empty($nik))
			{
				$data = [];
			}
			else
			{
				$date = convert_date2($exp[3]);
				$time = date('H:i:s',strtotime($exp[4]));

				$data = [
					'nik' => $nik,
					'date' => $date,
					'time' => $time
				];
			}
		
			$insert[] = $data;
		}

		return array_filter($insert);
	}

	public function generate_absen_fingerspotV4($text)
	{
		foreach ($text as $value) 
		{
			$exp = explode(",",$value);

			$nik = $exp[1];

			if($nik=="NIP" || empty($nik))
			{
				$data = [];
			}
			else
			{
				$date = convert_date3($exp[3]);
				$time = date('H:i:s',strtotime($exp[4]));

				$data = [
					'nik' => $nik,
					'date' => $date,
					'time' => $time
				];
			}
		
			$insert[] = $data;
		}

		return array_filter($insert);
	}

	public function generate_absen_solution($text)
	{
		foreach ($text as $value) 
		{
			$exp = explode(" ",$value);

			$nik = $exp[2];

			$pattern = "/\n/";
			if (preg_match($pattern, $nik)) 
			{
				$parts = explode("\n", $nik);
				$firstPart = $parts[0];
				$nikx = trim($firstPart);
			} 
			else 
			{
				$nikx = $nik;
			}
			
			if($nikx=="NIK" || empty($nikx))
			{
				$data = [];
			}
			else
			{
				$date = convert_date($exp[0]);
				$time = date('H:i:s',strtotime($exp[1]));

				$data = [
					'nik' => $nikx,
					'date' => $date,
					'time' => $time
				];
			}

			$insert[] = $data;
		}

		// dd($insert);

		return array_filter($insert);
	}

	public function generate_absen_solutionV2($text)
	{
		foreach ($text as $value) 
		{
			$exp = explode(" ",$value);

			$nik = $exp[2];

			$pattern = "/\n/";
			if (preg_match($pattern, $nik)) 
			{
				$parts = explode("\n", $nik);
				$firstPart = $parts[0];
				$nikx = trim($firstPart);
			} 
			else 
			{
				$nikx = $nik;
			}
			
			if($nikx=="NIK" || empty($nikx))
			{
				$data = [];
			}
			else
			{
				$date = convert_date($exp[0]);
				$time = date('H:i:s',strtotime($exp[1]));

				$data = [
					'nik' => $nikx,
					'date' => $date,
					'time' => $time
				];
			}

			$insert[] = $data;
		}

		// dd($insert);

		return array_filter($insert);
	}

	function generate_manual($path)
	{
		
	}

	public function fill_chunck($array, $parts) 
	{
		$t = 0;
		$result = array_fill(0, $parts - 1, array());
		$max = ceil(count($array) / $parts);
		foreach($array as $v) {
				count($result[$t]) >= $max and $t ++;
				$result[$t][] = $v;
		}
		return $result;
	}

	public function generate_report_absensi($data)
	{
		$department = $data['department'];
    $lokasi = $data['lokasi'];
    $periode = $data['periode'];

		$dept = Department::find($department);
    $loc = Lokasi::find($lokasi);

		$convert = date('m-Y',strtotime($periode));
    $exp = explode('-',$convert);

    $kal = CAL_GREGORIAN;
		$bln = $exp[0];
		$thn = $exp[1];

    $hari = cal_days_in_month($kal, $bln, $thn);

    $data = [];
    $date_now = date("Y-m-d");

		$data['jumhari'] = $hari;

		// $get_user = User::where('department_id',$department)
		// 								->where('lokasi_id',$lokasi)
		// 								->orderBy('jabatan_id','ASC')
		// 								->get();

		$get_user = DB::table('view_employee_active')
									->where('department_id',$department)
									->where('lokasi_id',$lokasi)
									->orderBy('jabatan_id','ASC')
									->get();

		foreach ($get_user as $key => $employee) 
		{
			$users_id = $employee->id;
			$nik = $employee->nik; 
      $mid = $employee->id;
			$jabatan = $employee->jabatan_id;
			$join_date = $employee->join_date;

			$absen_month 	= $this->pluckAbsen($bln, $thn, $nik);

			// $otd = 0;

			for ($d=1; $d <= $data['jumhari'] ; $d++) 
      { 
				$hari 	= array_key_exists($d, $absen_month) ? $absen_month[$d]['hari'] : $d;
				$time 	= mktime(12, 0, 0, $bln, $hari, $thn);

				$hari = DateTime::createFromFormat('Y-m-d',date('Y-m-d', $time))->format('D');

				$this->checkAttendace($users_id, date('Y-m-d', $time));

				if (date('Y-m-d', $time) < $join_date) // Cek Jika Absen Belum Melebihi Join Date
				{
					$day = [
						'users_id' => $users_id,
						'date' => date('Y-m-d', $time),
						'time' => null,
						'label'	=> 'NULL'
					];
				}
				else
				{
					if (array_key_exists($d, $absen_month)) // Cek Jika Absensi Ada
					{
						$day = [
							'users_id' => $users_id,
							'date' => $absen_month[$d]['just_date'],
							'time' => $absen_month[$d]['jam'],
							'label'	=> $jabatan > 3 ? $this->checkTelat($d, $absen_month, $mid)['status'] : 'H'
						];
					}
					else
					{
						if (date('Y-m-d', $time) >= $date_now) // Cek Jika Absensi Belum Melawati Hari
						{
							$day = [
								'users_id' => $users_id,
								'date' => date('Y-m-d', $time),
								'time' => null,
								'label'	=> 'NULL'
							];
						}
						else
						{
							if ($hari == 'Sun') // Cek Jika Hari Absensi Minggu
							{
								$day = [
									'users_id' => $users_id,
									'date' => date('Y-m-d', $time),
									'time' => null,
									'label'	=> 'OFF'
								];
							}
							else
							{
								$libur = $this->pluckLibur(date('Y-m-d', $time));
								$ijin = $this->pluckIjin(date('Y-m-d', $time), $users_id);
								$cuti = $this->pluckCuti(date('Y-m-d', $time), $users_id);
								$cuti_bersama = $this->pluckCutiBersama(date('Y-m-d', $time));
								$pd = $this->pluckPd(date('Y-m-d', $time), $users_id);

								$remarks = $this->checkAbsen(date('Y-m-d', $time), $users_id)['status'];

								if ($remarks=='H') 
								{
									$day = [
										'users_id' => $users_id,
										'date' => date('Y-m-d', $time),
										'time' => null,
										'label'	=> 'H'
									];
								}
								else
								{
									if ($libur > 0) 
									{
										$day = [
											'users_id' => $users_id,
											'date' => date('Y-m-d', $time),
											'time' => null,
											'label'	=> 'LB'
										];
									}
									else if ($ijin['count'] > 0)
									{
										$day = [
											'users_id' => $users_id,
											'date' => date('Y-m-d', $time),
											'time' => null,
											'label'	=> $ijin['label']
										];
									}
									else if ($cuti['count'] > 0)
									{
										$day = [
											'users_id' => $users_id,
											'date' => date('Y-m-d', $time),
											'time' => null,
											'label'	=> $cuti['label']
										];
									}
									else if ($cuti_bersama['count'] > 0)
									{
										$day = [
											'users_id' => $users_id,
											'date' => date('Y-m-d', $time),
											'time' => null,
											'label'	=> $cuti_bersama['label']
										];
									}
									else if ($pd['count'] > 0)
									{
										$day = [
											'users_id' => $users_id,
											'date' => date('Y-m-d', $time),
											'time' => null,
											'label'	=> $pd['label']
										];
									}
									else
									{
										$day = [
											'users_id' => $users_id,
											'date' => date('Y-m-d', $time),
											'time' => null,
											'label'	=> $jabatan > 3 ? $remarks : 'H'
										];
									}
								}
									
							}
						}
					}
				}

				

				$this->recordAttendance($day);
			}
		}
	}

	public function generate_report_absensi_resign($data)
	{
		$department = $data['department'];
    $lokasi = $data['lokasi'];
    $periode = $data['periode'];

		$dept = Department::find($department);
    $loc = Lokasi::find($lokasi);

		$convert = date('m-Y',strtotime($periode));
    $exp = explode('-',$convert);

    $kal = CAL_GREGORIAN;
		$bln = $exp[0];
		$thn = $exp[1];

		$end_date = $thn.'-'.$bln.'-20';
		$start_date = date('Y-m-t',strtotime($end_date));

		$start_date2 = $thn.'-'.$bln.'-01';

    $hari = cal_days_in_month($kal, $bln, $thn);

    $data = [];
    $date_now = date("Y-m-d");

		$data['jumhari'] = $hari;

		$get_user = DB::table('view_employee_resign')
									->where('department_id',$department)
									->where('lokasi_id',$lokasi)
									->where('resign_date','>=',$start_date2)
									->orderBy('jabatan_id','ASC')
									->get();

		// dd($get_user);

		foreach ($get_user as $key => $employee) 
		{
			$users_id = $employee->id;
			$nik = $employee->nik; 
      $mid = $employee->id;
			$jabatan = $employee->jabatan_id;
			$join_date = $employee->join_date;
			$resign_date = $employee->resign_date;

			$absen_month 	= $this->pluckAbsen($bln, $thn, $nik);

			// $otd = 0;

			for ($d=1; $d <= $data['jumhari'] ; $d++) 
      { 
				$hari 	= array_key_exists($d, $absen_month) ? $absen_month[$d]['hari'] : $d;
				$time 	= mktime(12, 0, 0, $bln, $hari, $thn);

				$hari = DateTime::createFromFormat('Y-m-d',date('Y-m-d', $time))->format('D');

				$this->checkAttendace($users_id, date('Y-m-d', $time));

				if (date('Y-m-d', $time) < $join_date || date('Y-m-d', $time) > $resign_date) // Cek Jika Absen Belum Melebihi Join Date & Melebihi Resign Date
				{
					$day = [
						'users_id' => $users_id,
						'date' => date('Y-m-d', $time),
						'time' => null,
						'label'	=> 'NULL'
					];
				}
				else
				{
					if (array_key_exists($d, $absen_month)) // Cek Jika Absensi Ada
					{
						$day = [
							'users_id' => $users_id,
							'date' => $absen_month[$d]['just_date'],
							'time' => $absen_month[$d]['jam'],
							'label'	=> $jabatan > 3 ? $this->checkTelat($d, $absen_month, $mid)['status'] : 'H'
						];
					}
					else
					{
						if (date('Y-m-d', $time) >= $date_now) // Cek Jika Absensi Belum Melawati Hari
						{
							$day = [
								'users_id' => $users_id,
								'date' => date('Y-m-d', $time),
								'time' => null,
								'label'	=> 'NULL'
							];
						}
						else
						{
							if ($hari == 'Sun') // Cek Jika Hari Absensi Minggu
							{
								$day = [
									'users_id' => $users_id,
									'date' => date('Y-m-d', $time),
									'time' => null,
									'label'	=> 'OFF'
								];
							}
							else
							{
								$libur = $this->pluckLibur(date('Y-m-d', $time));
								$ijin = $this->pluckIjin(date('Y-m-d', $time), $users_id);
								$cuti = $this->pluckCuti(date('Y-m-d', $time), $users_id);
								$cuti_bersama = $this->pluckCutiBersama(date('Y-m-d', $time));
								$pd = $this->pluckPd(date('Y-m-d', $time), $users_id);

								$remarks = $this->checkAbsen(date('Y-m-d', $time), $users_id)['status'];

								if ($remarks=='H') 
								{
									$day = [
										'users_id' => $users_id,
										'date' => date('Y-m-d', $time),
										'time' => null,
										'label'	=> 'H'
									];
								}
								else
								{
									if ($libur > 0) 
									{
										$day = [
											'users_id' => $users_id,
											'date' => date('Y-m-d', $time),
											'time' => null,
											'label'	=> 'LB'
										];
									}
									else if ($ijin['count'] > 0)
									{
										$day = [
											'users_id' => $users_id,
											'date' => date('Y-m-d', $time),
											'time' => null,
											'label'	=> $ijin['label']
										];
									}
									else if ($cuti['count'] > 0)
									{
										$day = [
											'users_id' => $users_id,
											'date' => date('Y-m-d', $time),
											'time' => null,
											'label'	=> $cuti['label']
										];
									}
									else if ($cuti_bersama['count'] > 0)
									{
										$day = [
											'users_id' => $users_id,
											'date' => date('Y-m-d', $time),
											'time' => null,
											'label'	=> $cuti_bersama['label']
										];
									}
									else if ($pd['count'] > 0)
									{
										$day = [
											'users_id' => $users_id,
											'date' => date('Y-m-d', $time),
											'time' => null,
											'label'	=> $pd['label']
										];
									}
									else
									{
										$day = [
											'users_id' => $users_id,
											'date' => date('Y-m-d', $time),
											'time' => null,
											'label'	=> $jabatan > 3 ? $remarks : 'H'
										];
									}	
								}
							}
						}
					}
				}

				$this->recordAttendance($day);
			}
		}
	}

	public function view_report_absensi($data)
	{
		$department = $data['department'];
    $lokasi = $data['lokasi'];
    $periode = $data['periode'];

		$dept = Department::find($department);
    $loc = Lokasi::find($lokasi);

		$convert = date('m-Y',strtotime($periode));
    $exp = explode('-',$convert);

    $kal = CAL_GREGORIAN;
		$bln = $exp[0];
		$thn = $exp[1];

    $hari = cal_days_in_month($kal, $bln, $thn);

    $data = [];

		$data['jumhari'] = $hari;

    $absen 	= [];

		$get_user = User::where('department_id',$department)
										->where('lokasi_id',$lokasi)
										->whereNull('resign_st')
										->orderBy('jabatan_id','ASC')
										->orderBy('nik','ASC')
										->get();

		foreach ($get_user as $key => $employee) 
		{
			$users_id = $employee->id;
			$nik = $employee->nik; 
			$name = $employee->name;
			$jabatan = $employee->jabatan->title;

			$dailyAttendance = $this->dailyAttendance($bln, $thn, $users_id);

			$hadir = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'H');
			$telat = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'T');
			$sakit = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'S');
			$ijin = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'I');
			$alpa = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'A');
			$iso = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'ISO');
      $wfh = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'WFH');
      $dl = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'DL');
      $off = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'OFF');
      $ct = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'CT');
      $cb = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'CB');
      $ck = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'CK');
      $pd = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'PD');

      $hadir_all = $hadir + $telat + $pd + $dl;

			$mdp = $this->getMdpValues($hari,$off);
      $mda = $hadir_all;
      $mdl = $mda - $mdp;

			$absen[] = [
				'nik' => $nik,
				'name' => $name,
				'jabatan' => $jabatan,
				'daily' => $dailyAttendance,
				'hadir' => $hadir_all,
				'telat' => $telat,
				'sakit' => $sakit,
				'ijin' => $ijin,
				'alpa' => $alpa,
				'iso' => $iso,
        'wfh' => $wfh,
        'dl' => $dl,
        'off' => $off,
        'ct' => $ct,
        'cb' => $cb,
        'ck' => $ck,
        'pd' => $pd,
				'jumhari' => $hari,
				'mdp' => $mdp,
        'mda' => $mda,
        'mdl' => $mdl
			];
		}

		$sum_mdp = array_sum(array_column($absen,'mdp'));
    $sum_mda = array_sum(array_column($absen,'mda'));
    $ratio = ($sum_mda / $sum_mdp) * 100;

		$data = [
			'absen' => $absen,
			'hari' => $hari,
			'department' => isset($department) ? $dept->title : 'Semua Department',
      'lokasi' => $loc->title,
			'sum_hadir' => array_sum(array_column($absen,'hadir')),
      'sum_telat' => array_sum(array_column($absen,'telat')),
      'sum_sakit' => array_sum(array_column($absen,'sakit')),
      'sum_ijin' => array_sum(array_column($absen,'ijin')),
      'sum_alpa' => array_sum(array_column($absen,'alpa')),
      'sum_iso' => array_sum(array_column($absen,'iso')),
      'sum_wfh' => array_sum(array_column($absen,'wfh')),
      'sum_dl' => array_sum(array_column($absen,'dl')),
      'sum_off' => array_sum(array_column($absen,'off')),
      'sum_ct' => array_sum(array_column($absen,'ct')),
      'sum_cb' => array_sum(array_column($absen,'cb')),
      'sum_ck' => array_sum(array_column($absen,'ck')),
      'sum_pd' => array_sum(array_column($absen,'pd')),
      'sum_mdp' => $sum_mdp,
      'sum_mda' => $sum_mda,
      'sum_mdl' => array_sum(array_column($absen,'mdl')),
      'sum_hari' => array_sum(array_column($absen,'jumhari')),
      'ratio' =>  round($ratio, 2)
		];

		return $data;
	}

	public function view_report_absensi_resign($data)
	{
		$department = $data['department'];
    $lokasi = $data['lokasi'];
    $periode = $data['periode'];

		$dept = Department::find($department);
    $loc = Lokasi::find($lokasi);

		$convert = date('m-Y',strtotime($periode));
    $exp = explode('-',$convert);

    $kal = CAL_GREGORIAN;
		$bln = $exp[0];
		$thn = $exp[1];

		$end_date = $thn.'-'.$bln.'-20';
		$start_date = date('Y-m-t',strtotime($end_date));

		$start_date2 = $thn.'-'.$bln.'-01';

    $hari = cal_days_in_month($kal, $bln, $thn);

    $data = [];

		$data['jumhari'] = $hari;

    $absen 	= [];

		$get_user = DB::table('view_employee_resign')
									->where('department_id',$department)
									->where('lokasi_id',$lokasi)
									->where('resign_date','>=',$start_date2)
									->orderBy('jabatan_id','ASC')
									->orderBy('nik','ASC')
									->get();

		foreach ($get_user as $key => $employee) 
		{
			$users_id = $employee->id;
			$nik = $employee->nik; 
			$name = $employee->name;
			$jabatan = $employee->jabatan;

			$dailyAttendance = $this->dailyAttendance($bln, $thn, $users_id);

			$hadir = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'H');
			$telat = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'T');
			$sakit = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'S');
			$ijin = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'I');
			$alpa = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'A');
			$iso = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'ISO');
      $wfh = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'WFH');
      $dl = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'DL');
      $off = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'OFF');
      $ct = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'CT');
      $cb = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'CB');
      $ck = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'CK');
      $pd = $this->getLabel(array_count_values(array_column($dailyAttendance,'label')),'PD');

      $hadir_all = $hadir + $telat + $pd + $dl;

			$mdp = $this->getMdpValues($hari,$off);
      $mda = $hadir_all;
      $mdl = $mda - $mdp;

			$absen[] = [
				'nik' => $nik,
				'name' => $name,
				'jabatan' => $jabatan,
				'daily' => $dailyAttendance,
				'hadir' => $hadir_all,
				'telat' => $telat,
				'sakit' => $sakit,
				'ijin' => $ijin,
				'alpa' => $alpa,
				'iso' => $iso,
        'wfh' => $wfh,
        'dl' => $dl,
        'off' => $off,
        'ct' => $ct,
        'cb' => $cb,
        'ck' => $ck,
        'pd' => $pd,
				'jumhari' => $hari,
				'mdp' => $mdp,
        'mda' => $mda,
        'mdl' => $mdl
			];
		}

		$sum_mdp = array_sum(array_column($absen,'mdp'));
    $sum_mda = array_sum(array_column($absen,'mda'));
    $ratio = ($sum_mda / $sum_mdp) * 100;

		$data = [
			'absen' => $absen,
			'hari' => $hari,
			'department' => isset($department) ? $dept->title : 'Semua Department',
      'lokasi' => $loc->title,
			'sum_hadir' => array_sum(array_column($absen,'hadir')),
      'sum_telat' => array_sum(array_column($absen,'telat')),
      'sum_sakit' => array_sum(array_column($absen,'sakit')),
      'sum_ijin' => array_sum(array_column($absen,'ijin')),
      'sum_alpa' => array_sum(array_column($absen,'alpa')),
      'sum_iso' => array_sum(array_column($absen,'iso')),
      'sum_wfh' => array_sum(array_column($absen,'wfh')),
      'sum_dl' => array_sum(array_column($absen,'dl')),
      'sum_off' => array_sum(array_column($absen,'off')),
      'sum_ct' => array_sum(array_column($absen,'ct')),
      'sum_cb' => array_sum(array_column($absen,'cb')),
      'sum_ck' => array_sum(array_column($absen,'ck')),
      'sum_pd' => array_sum(array_column($absen,'pd')),
      'sum_mdp' => $sum_mdp,
      'sum_mda' => $sum_mda,
      'sum_mdl' => array_sum(array_column($absen,'mdl')),
      'sum_hari' => array_sum(array_column($absen,'jumhari')),
      'ratio' =>  round($ratio, 2)
		];

		return $data;
	}

	public function getLabel($value,$string) 
  {
    if (!array_key_exists($string, $value)) 
    {
      $value= 0;
    } else {
      $value = $value[$string];
    }
    return $value;
  } 

	public function getMdpValues($hari, $off)
  {
    $result = $hari - $off;
    return $result;
  }

	public function pluckAbsen($bln, $tahun, $nik)
  {
    $arr = Absensi::where('nik',$nik)
                  ->whereYear('date', $tahun)
                  ->whereMonth('date',$bln)
                  ->orderBy('time','DESC')
                  ->get();
    $pluck = [];
    foreach ($arr as $key => $data) 
    {
      $dash_explode   = explode('-', $data->date);
      $hari 			    = end($dash_explode);

      $pluck[(int)$hari] = [
				'just_date'	=> $data->date,
				'jam'				=> $data->time,
				'hari'			=> (int)$hari
			];
    }

    return $pluck;
  }

	public function pluckLibur($date)
  {
    $arr = CutiLines::where('cuti_type_id',6)
                    ->where('date', $date)
                    ->get();

		if (count($arr) > 0) 
		{
			return 1;
		}
		else
		{
			return 0;
		}
  }

	public function pluckIjin($date, $mid)
  {
    $arr = AbsensiIjinLines::where('users_id',$mid)
													->where('status',1)
													->where('date', $date)
													->get();

		if (count($arr) > 0) 
		{
			foreach ($arr as $value) 
			{
				$data = [
					'count' => 1,
					'label' => $value->absensi_ijin_type->label
				];
			}
		}
		else
		{
			$data = [
				'count' => 0,
				'label' => ''
			]; 
		}

		return $data;
  }

	public function pluckCuti($date, $mid)
  {
    $arr = CutiLines::where('employee_id',$mid)
                    ->where('approval_st',1)
                    ->where('date', $date)
                    ->get();

		if (count($arr) > 0) 
		{
			foreach ($arr as $value) 
			{
				$data = [
					'count' => 1,
					'label' => $value->cuti_type->kode
				];
			}
		}
		else
		{
			$data = [
				'count' => 0,
				'label' => ''
			]; 
		}

		return $data;
  }

	public function pluckCutiBersama($date)
  {
    $arr = CutiLines::where('cuti_type_id',5)
										->where('date', $date)
                    ->get();

		if (count($arr) > 0) 
		{
			foreach ($arr as $value) 
			{
				$data = [
					'count' => 1,
					'label' => 'CB'
				];
			}
		}
		else
		{
			$data = [
				'count' => 0,
				'label' => ''
			]; 
		}

		return $data;
  }

	public function pluckPd($date, $mid)
  {
    $arr = DinasLines::where('users_id',$mid)
                    ->where('status',1)
                    ->where('date', $date)
                    ->get();

		if (count($arr) > 0) 
		{
			foreach ($arr as $value) 
			{
				$data = [
					'count' => 1,
					'label' => 'PD'
				];
			}
		}
		else
		{
			$data = [
				'count' => 0,
				'label' => ''
			]; 
		}

		return $data;
  }

	public function checkTelat($d, $absen_month, $mid)
  {
		$cek = AttendanceExcept::where('users_id',$mid)->first();

		if (isset($cek)) 
		{
			$timein = $cek->time;
		}
		else
		{
			$timein = "08:01:00";
		}

    $response 	= [
			'status'  => 'H',
		];

    if($absen_month[$d]['jam'] > $timein)
    {
      $date = $absen_month[$d]['just_date'];
      $remarks = AbsensiRemarks::where('users_id',$mid)
                               ->where('date',$date)
                               ->get();

      $keluar = SuratIjin::where('employee_id',$mid)
                         ->where('date',$date)
                         ->where('time_start','<',$timein)
                         ->where('approval1_st',1)
                         ->get();

      if(count($remarks) > 0 || count($keluar) > 0)
      {
        $response = [
          'status'  => 'H'
        ];
      }
      else
      {
        $response = [
          'status'  => 'T'
        ];
      }
    }

    return $response;
  }

	public function checkAbsen($date, $mid)
  {
    $remarks = AbsensiRemarks::where('users_id',$mid)
                              ->where('date',$date)
                              ->get();

    $keluar = SuratIjin::where('employee_id',$mid)
                        ->where('date',$date)
                        ->where('approval1_st',1)
                        ->get();

    if(count($remarks) > 0 || count($keluar) > 0)
    {
      $response = [
        'status'  => 'H'
      ];
    }
    else
    {
			$response = [
				'status'  => 'A'
			];
    }

    return $response;
  }

	public function checkAttendace($users_id, $date)
	{
		$cek = Attendance::where('users_id',$users_id)
										 ->where('date',$date)
										 ->get();

		if (count($cek) > 0) 
		{
			return Attendance::where('users_id',$users_id)
											 ->where('date',$date)
											 ->delete();
		}
	}

	public function recordAttendance($data)
	{
		return Attendance::create($data);
	}

	public function dailyAttendance($bln, $thn, $users_id)
	{
		$data = [];

		$row = Attendance::whereYear('date', $thn)
										 ->whereMonth('date',$bln)
										 ->where('users_id',$users_id)
										 ->orderBy('date','ASC')
										 ->get();

		foreach ($row as $value) 
		{
			$data[] = [
				'date' => $value->date,
				'label' => $value->label,
				'color' => $this->checkColor($value->label)
			];
		}

		return $data;
	}

	public function checkColor($label)
	{
		$color = '';

		if($label == 'S')
    {
      $color = 'text-success';
    }

    if($label == 'I')
    {
      $color = 'text-warning';
    }

    if($label == 'A')
    {
      $color = 'text-danger';
    }

    if($label == 'CT' || $label == 'CK' ||$label == 'CB')
    {
      $color = 'text-brown';
    }

    if($label == 'PD' || $label == 'DL' )
    {
      $color = 'text-grey';
    }

    if($label == 'T')
    {
      $color = 'text-pink';
    }

    if($label == 'LB')
    {
      $color = 'text-primary';
    }

		return $color;
	}
}