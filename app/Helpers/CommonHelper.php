<?php

use App\Models\AbsensiIjinLines;
use App\Models\ApprovalHr;
use App\Models\Cabang;
use App\Models\CutiLines;
use App\Models\Department;
use App\Models\DepartmentJabatan;
use App\Models\DinasLinesKendaraan;
use App\Models\Divisi;
use App\Models\History;
use App\Models\Lokasi;
use App\Models\Mutasi;
use App\Models\User;
use App\Models\WhatsappMonitor;
use Illuminate\Support\Facades\DB;

function getBawahan()
{
	$users_id = auth()->user()->id;

	return User::where('atasan_id',$users_id)->get();
}

function generate_nik($join_date, $lokasi)
{
  $exp_join = explode('-', $join_date);

  $select_kode = DB::raw('RIGHT(users.nik,3) as kode');
  $query = DB::table('users')
    ->select($select_kode)
    ->whereYear('join_date', $exp_join[0])
    ->where('lokasi_id', $lokasi)
    ->orderBy('id', 'DESC')
    ->limit(1);
  $get = $query->get();
  $count = count($get);

  foreach ($get as $get) {
    $data = $get->kode;
  }

  if ($count <> 0) {
    $kode = intval($data) + 1;
  } else {
    $kode = 1;
  }

  $kode_area = Lokasi::find($lokasi)->kode;

  $yy = date('y', strtotime($join_date));

  $kodemax = str_pad($kode, 3, "0", STR_PAD_LEFT); 
  $kodejadi = $kode_area . $yy . $kodemax;
  return $kodejadi;
}

function history($title, $action, $keterangan)
{
  $data2 = array(
    'title' => $title,
    'action' => $action,
    'desc' => $keterangan
  );

  return History::create($data2);
}

function time_elapsed_string($datetime, $full = false, $singkat = false)
{
  $now = new DateTime;
  $ago = new DateTime($datetime);
  $diff = (array) $now->diff($ago);

  $diff['w'] = floor($diff['d'] / 7);
  $diff['d'] -= $diff['w'] * 7;
  if (!$singkat) {
    $string = array(
      'y' => 'tahun',
      'm' => 'bulan',
    );
  } else {
    $string = array(
      'y' => 'Thn',
      'm' => 'Bln',
    );
  }
  foreach ($string as $k => &$v) {
    if ($diff[$k]) {
      $v = $diff[$k] . ' ' . $v . ($diff[$k] > 1 ? '' : '');
    } else {
      unset($string[$k]);
    }
  }

  if (!$full) $string = array_slice($string, 0, 1);
  if (!$singkat) {
    return $string ? implode(', ', $string) . ' yang lalu' : 'just now';
  } else {
    return $string ? implode(', ', $string) . '' : '< 1 Bln';
  }
}

function time_elapsed_string2($datetime, $full = false, $singkat = false)
{
  $now = new DateTime;
  $ago = new DateTime($datetime);
  $diff = (array) $now->diff($ago);

  $diff['w'] = floor($diff['d'] / 7);
  $diff['d'] -= $diff['w'] * 7;
  if (!$singkat) {
    $string = array(
      'y' => 'tahun',
      'm' => 'bulan',
    );
  } else {
    $string = array(
      'y' => 'Thn',
      'm' => 'Bln',
    );
  }
  foreach ($string as $k => &$v) {
    if ($diff[$k]) {
      $v = $diff[$k] . ' ' . $v . ($diff[$k] > 1 ? '' : '');
    } else {
      unset($string[$k]);
    }
  }

  if (!$full) $string = array_slice($string, 0, 1);
  if (!$singkat) {
    return $string ? implode(', ', $string) : 'just now';
  } else {
    return $string ? implode(', ', $string) . '' : '< 1 Bln';
  }
}

//Format Medium date
if (!function_exists('mediumdate_indo')) {
  function mediumdate_indo($tgl)
  {
    $ubah = gmdate($tgl, time() + 60 * 60 * 8);
    $pecah = explode("-", $ubah);
    $tanggal = $pecah[2];
    $bulan = medium_bulan($pecah[1]);
    $tahun = date('y', strtotime($tgl));
    return $tanggal . '-' . $bulan . '-' . $tahun;
  }
}

if (!function_exists('medium_bulan')) {
  function medium_bulan($bln)
  {
    switch ($bln) {
      case 1:
        return "Jan";
        break;
      case 2:
        return "Feb";
        break;
      case 3:
        return "Mar";
        break;
      case 4:
        return "Apr";
        break;
      case 5:
        return "Mei";
        break;
      case 6:
        return "Jun";
        break;
      case 7:
        return "Jul";
        break;
      case 8:
        return "Ags";
        break;
      case 9:
        return "Sep";
        break;
      case 10:
        return "Okt";
        break;
      case 11:
        return "Nov";
        break;
      case 12:
        return "Des";
        break;
    }
  }
}

function tgl_indo($tanggal)
{
  if (empty($tanggal) || $tanggal == '0000-00-00') {
    return '-';
  } else {
    $bulan = array(
      1 =>   'Januari',
      'Februari',
      'Maret',
      'April',
      'Mei',
      'Juni',
      'Juli',
      'Agustus',
      'September',
      'Oktober',
      'November',
      'Desember'
    );
    $pecahkan = explode('-', $tanggal);

    // variabel pecahkan 0 = tahun
    // variabel pecahkan 1 = bulan
    // variabel pecahkan 2 = tanggal

    return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
  }
}

function tgl_def($tanggal)
{
  if (empty($tanggal) || $tanggal == '0000-00-00') {
    return '-';
  } else {
    $pecahkan = explode('-', $tanggal);

    // variabel pecahkan 0 = tahun
    // variabel pecahkan 1 = bulan
    // variabel pecahkan 2 = tanggal

    return $pecahkan[2] . '/' . $pecahkan[1] . '/' . $pecahkan[0];
  }
}

function get_saldo_cuti($id, $join_date, $tipe)
{
  if ($tipe == "kemarin") {
    $tglg = date("Y") . date("-m-d", strtotime($join_date));
    if (strtotime($tglg) > strtotime(date("Ymd"))) {
      $tglg = date("Y-m-d", strtotime($tglg . "- 1 year"));
    }
    $tglg = date("Ymd", strtotime($tglg . "- 1 day"));
    $tglnow = $tglg;
  } elseif ($tipe == "kemarin2") {
    $tglg = date("Y") . date("-m-d", strtotime($join_date));
    if (strtotime($tglg) > strtotime(date("Ymd"))) {
      $tglg = date("Y-m-d", strtotime($tglg . "-1 year"));
    }
    $tglg = date("Ymd", strtotime($tglg . "- 1 year"));
    $tglg = date("Ymd", strtotime($tglg . "- 1 day"));
    $tglnow = $tglg;
  } else {
    $tglnow = date("Ymd");
  }

  $sisaCuti = 0;
  $saldoSebelumnya = 0;
  $temp = 1;

  while (strtotime($join_date) <= strtotime($tglnow)) {
    $tgl2 = date("Y-m-d", strtotime($join_date . "+ 1 year"));
    $tgl2x = date("Y-m-d", strtotime($join_date . "+ 1 year"));
    if (strtotime($tgl2x) > strtotime($tglnow)) {
      $tgl2x = date("Y-m-d", strtotime($tglnow));
    }

    if ($temp == 1) {
      $addCuti = 0;
    } else {
      $addCuti = 12;
    }

    $cuti_pribadi = CutiLines::where('employee_id', $id)
      ->where('date', '>=', $join_date)
      ->where('date', '<=', $tgl2)
      ->where('approval_st', 1)
      ->where('cuti_type_id', 1)
      ->get()->count();

    $ijin = AbsensiIjinLines::where('users_id', $id)
      ->where('date', '>=', $join_date)
      ->where('date', '<=', $tgl2)
      ->where('absensi_ijin_type_id', 2)
      ->where('status', 1)
      ->get()->count();

    $cuti_bersama = CutiLines::where('date', '>=', $join_date)
      ->where('date', '<=', $tgl2x)
      ->where('cuti_type_id', 5)
      ->get()->count();

    $sisaCuti = $addCuti + $saldoSebelumnya - $cuti_pribadi - $cuti_bersama - $ijin;

    if ($sisaCuti < 0) {
      $saldoSebelumnya = $sisaCuti;
    } else {
      $saldoSebelumnya = 0;
    }
    $temp++;
    $join_date = date("Y-m-d", strtotime($join_date . "+ 1 year"));
  }

  return $sisaCuti;
}

function get_hak_cuti($id, $join_date, $tipe)
{
  if ($tipe == "kemarin") {
    $tglg = date("Y") . date("-m-d", strtotime($join_date));
    if (strtotime($tglg) > strtotime(date("Ymd"))) {
      $tglg = date("Y-m-d", strtotime($tglg . "- 1 year"));
    }
    $tglg = date("Ymd", strtotime($tglg . "- 1 day"));
    $tglnow = $tglg;
  } elseif ($tipe == "kemarin2") {
    $tglg = date("Y") . date("-m-d", strtotime($join_date));
    if (strtotime($tglg) > strtotime(date("Ymd"))) {
      $tglg = date("Y-m-d", strtotime($tglg . "-1 year"));
    }
    $tglg = date("Ymd", strtotime($tglg . "- 1 year"));
    $tglg = date("Ymd", strtotime($tglg . "- 1 day"));
    $tglnow = $tglg;
  } else {
    $tglnow = date("Ymd");
  }

  $sisaCuti = 0;
  $temp = 1;

  while (strtotime($join_date) <= strtotime($tglnow)) {
    $tgl2x = date("Y-m-d", strtotime($join_date . "+ 1 year"));
    if (strtotime($tgl2x) > strtotime($tglnow)) {
      $tgl2x = date("Y-m-d", strtotime($tglnow));
    }

    if ($temp == 1) {
      $addCuti = 0;
    } else {
      $addCuti = 12;
    }

    $sisaCuti = $addCuti;

    $temp++;
    $join_date = date("Y-m-d", strtotime($join_date . "+ 1 year"));
  }

  return $sisaCuti;
}

function removeFile($nik, $file)
{
	if ($file!='default.jpg' || !empty($file)) 
	{
		$url = public_path('/storage/upload/employee/'.$nik.'/'.$file);
	
		if(file_exists($url))
		{
			return unlink($url);
		}
	}
}

function generate_sloting($department, $jabatan, $cabang, $principle)
{
  $select_kode = DB::raw('RIGHT(sloting.kd,3) as kode');
  $query = DB::table('sloting')
    ->select($select_kode)
    ->where('department_id', $department)
    ->where('department_jabatan_id', $jabatan)
    ->where('cabang_id', $cabang)
    ->where('divisi_id', $principle)
    ->orderBy('id', 'DESC')
    ->limit(1);
  $get = $query->get();
  $count = count($get);

  foreach ($get as $get) {
    $data = $get->kode;
  }

  if ($count <> 0) {
    $kode = intval($data) + 1;
  } else {
    $kode = 1;
  }

  $kode_dept = Department::find($department)->kode;
  $kode_deptjab = DepartmentJabatan::find($jabatan)->kode;
  $kode_cab = Cabang::find($cabang)->kode;
  $kode_prin = Divisi::find($principle)->kode;

  if ($kode_prin == 'ALL') {
    $prin = '';
  } else {
    $prin = $kode_prin;
  }

  $kodemax = str_pad($kode, 3, "0", STR_PAD_LEFT);
  $kodejadi = $kode_deptjab . $kode_dept . $kode_cab . $prin . $kodemax;
  return $kodejadi;
}

function get_cuti_periksa($lokasi)
{
  $result = ApprovalHr::where('lokasi_id', $lokasi)->first();
  return $result->users_id;
}

function get_cuti_setujui($user, $lokasi)
{
  $cek = User::find($user);
  $atasan = $cek->atasan_id;
  $role = $cek->role_id;

  if($role==2)
  {
    return $user;
  }
  else
  {
    return isset($atasan) ? $atasan : get_cuti_periksa($cek->lokasi_id);
  }
}

function get_cuti_ketahui($dep, $jab, $lokasi)
{
  if (empty($dep)) {
    $result = get_cuti_periksa($lokasi);
  } else {
    $get_manajer = Mutasi::where('department_id', $dep)
      ->where('m_jabatan_id', 3)
      ->where('status',1)
      ->limit(1);

    $get_gm = Mutasi::where('department_id', $dep)
      ->where('m_jabatan_id', 2)
      ->where('status',1)
      ->limit(1);

    $get_director = Department::find($dep);

    if ($jab >= 4) 
    {
      if (!empty($get_manajer->count())) 
      {
        $get = $get_manajer->first();
        $result = $get->user_id;
      } 
      else 
      {
        $result = get_cuti_periksa($lokasi);
      }
    } 
    else if ($jab == 3) 
    {
      if (!empty($get_gm->count())) 
      {
        $get = $get_gm->first();
        $result = $get->user_id;
      }
      else if (!empty($get_director->count())) 
      {
        $get = $get_director->first();
        $result = $get->direktur_id;
      } 
      else 
      {
        $result = get_cuti_periksa($lokasi);
      }
    } 
    else if ($jab == 2) 
    {
      if (!empty($get_director->count())) 
      {
        $get = $get_director->first();
        $result = $get->direktur_id;
      }
      else 
      {
        $result = get_cuti_periksa($lokasi);
      }
    }
  }

  return $result;
}

function get_director_name($id)
{
  $get = Department::where('direktur_id',$id)->first();
  $title = $get->title;
  return 'Direktur '. $title;
}

function get_biodata($user)
{
  $result = User::find($user);
  return $result;
}

function get_ttd($id)
{
  $get = User::find($id);

  $role = $get->role_id;
  $sign = $get->sign_file;
  $nik = $get->nik;

  if($role==5)
  {
    if(!empty($sign))
    {
      $result = asset('storage/upload/employee/'.$nik.'/'.$sign);
    }
    else
    {
      $result = asset('assets/images/signature.png');
    }
  }
  else
  {
    if(!empty($sign))
    {
      $result = asset('storage/upload/direktur/'.$sign);
    }
    else
    {
      $result = asset('assets/images/signature.png');
    }
  }

  return $result;
}

function callWhatsapp2($no_wa, $message)
{
	$post = [
		'api_key' => '8T6OC4DZRIIKSOOF',
		'number_key' => 'dKwcEw26JEOPNhFM',
		'phone_no' => $no_wa,
		'message' => $message
	];

	$url = 'https://api.watzap.id/v1/send_message';
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_URL => $url,// your preferred link
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_TIMEOUT => 30000,
		CURLOPT_SSL_VERIFYHOST => false,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_POSTFIELDS => json_encode($post),
		CURLOPT_HTTPHEADER => array(
				// Set here requred headers
				"accept: */*",
				"accept-language: en-US,en;q=0.8",
				"content-type: application/json",
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);

	// $data = [];

	if ($err) 
	{
		$data = [];
	} 
	else 
	{
		$data = json_decode($response,TRUE);
	}

	return $data;
}

function whatsappMonitor($no_wa, $teks_tengah, $new_message, $subject, $wa_status, $wa_message, $user_id)
{
	$user = User::find($user_id);

	$post_wa = [
		'teks' => $teks_tengah,
		'no_wa' => $no_wa,
		'message' => $new_message,
		'subject' => $subject,
		'status_api' => $wa_status,
		'message_api' => $wa_message,
		'lokasi_id' => $user->lokasi_id,
		'date' => date('Y-m-d H:i:s')
	];

	return WhatsappMonitor::create($post_wa);
}

function whatsappMessage($employee_name, $pengajuan, $approval_name, $kd, $status, $reject_excuse)
{
	$subject = "Approval Online HRIS - ".$pengajuan;

	if ($status=='approve') 
	{
		$teks = "Pengajuan ".$pengajuan." telah berhasil di approve. Klik link dibawah ini untuk melihat pengajuan :";
		$new_message   = "Halo ".$employee_name."\n\n".$teks;
	}
	elseif ($status=='reject') 
	{
		$teks = "Maaf, Pengajuan ".$pengajuan." anda telah di reject oleh ".$approval_name." dikarenakan ".$reject_excuse.". Klik link dibawah ini untuk melihat pengajuan :";
		$new_message   = "Halo ".$employee_name."\n\n".$teks;
	}
	elseif ($status=='resign_interview') 
	{
		$teks = "Silahkan untuk melakukan Exit Interview sebelum anda resign. Klik link dibawah ini :";
		$new_message   = "Halo ".$employee_name."\n\n".$teks;
	}
	elseif ($status=='resign_clearance') 
	{
		$teks = "Silahkan untuk melakukan Exit Clearance sebelum anda resign. Klik link dibawah ini :";
		$new_message   = "Halo ".$employee_name."\n\n".$teks;
	}
	else
	{
		$teks = "Karyawan *" . $employee_name . "* melakukan *".$pengajuan."* dengan nomor dokumen ".$kd.". Klik link dibawah ini untuk melakukan approval (".$status.") :";
		$new_message   = "Halo ".$approval_name."\n\n".$teks;
	}

	$data = [
		'subject' => $subject,
		'message' => $new_message
	];

	return $data;
}

function rupiah($angka) {
  $hasil = 'IDR ' . number_format($angka, 2, ",", ".");
  return $hasil;
}

function rupiah2($angka) {
  $hasil = 'IDR ' . number_format($angka, 0, ",", ".");
  return $hasil;
}

function rupiahnon($angka) {
  $hasil = number_format($angka, 0, ",", ".");
  return $hasil;
}

function rupiahnon2($angka) {
  $hasil = number_format($angka, 2, ",", ".");
  return $hasil;
}

function rupiahnon3($angka) {
  $hasil = number_format($angka, 2, ".", "");
  return $hasil;
}

function convert_date($value)
{
  $exp = explode('/',$value);
  $date = $exp[0];
  $month = $exp[1];
  $year = $exp[2];

  return $year.'-'.$month.'-'.$date;
}

function convert_date2($value)
{
  $exp = explode('-',$value);
  $date = $exp[0];
  $month = $exp[1];
  $year = $exp[2];

  return $year.'-'.$month.'-'.$date;
}

function convert_date3($value)
{
  $exp = explode('/',$value);
  $date = $exp[0];
  $month = $exp[1];
  $year = $exp[2];

  return $year.'-'.$month.'-'.$date;
}

function replace_npwp($value)
{
  if (!empty($value) || $value!="'0" || $value!="0") 
  {
    $v1 = str_replace("'","",$value);
    $v2 = str_replace(".","",$v1);
    $v3 = str_replace("-","",$v2);
    $v4 = str_replace('"','',$v3);

    if (!empty($v4)) 
    {
      return "'".$v4;
    }
  }
  else
  {
    return "";
  }
}

function daysdiffxx($val)
{
	$today = new DateTime();
	$date = new DateTime($val);
		
	$interval = $today->diff($date);
	$valx = $interval->format("%r%a");

	if($valx < 0)
	{
		$result = '<span class="badge badge-danger">'.$valx.'</span>';
	}
	else if ($valx > 30)
	{
		$result = '<span class="badge badge-primary">'.$valx.'</span>';
	}
	else
	{
		$result = '<span class="badge badge-default" style="background-color:#ffff00;">'.$valx.'</span>';
	}

	return $result;
}

function dinas_lokasi($id)
{
	$get = DinasLinesKendaraan::where('dinas_id',$id)->get();
	
	$max = count($get);

	if ($max > 0) 
	{
		$res = '';

		$no = 1;
		foreach ($get as $value) 
		{
			$nox = $no++;

			if ($nox != $max) 
			{
				$sepa = ', ';
			}
			else
			{
				$sepa = '';
			}

			$res .= isset($value->lokasi_tujuan) ? $value->lokasi_tujuan->title.$sepa : '';
		}

		return $res;
	}
	else
	{
		return '-';
	}
}

function dinas_kendaraan($id)
{
	$get = DinasLinesKendaraan::where('dinas_id',$id)->get();
	
	$max = count($get);

	if ($max > 0) 
	{
		$res = '';

		$no = 1;
		foreach ($get as $value) 
		{
			$nox = $no++;

			if ($nox != $max) 
			{
				$sepa = ', ';
			}
			else
			{
				$sepa = '';
			}

			$res .= $value->kendaraan->title.$sepa;
		}

		return $res;
	}
	else
	{
		return '-';
	}
}