<?php

namespace App\Services\Employee;

use App\Models\AppraisalItem;
use App\Models\AppraisalScore;
use App\Models\AppraisalScoreLines;
use App\Models\User;

class AppraisalServices
{
	public function detail($kd)
	{
		$header = AppraisalScore::where('kd',$kd)->first();
		$lines = AppraisalScoreLines::where('appraisal_score_id',$header->id)->get();

		$sum = AppraisalScoreLines::where('appraisal_score_id', $header->id)->sum('score');

		$score1 = AppraisalScoreLines::where('appraisal_score_id', $header->id)->where('score', 1)->sum('score');
		$score2 = AppraisalScoreLines::where('appraisal_score_id', $header->id)->where('score', 2)->sum('score');
		$score3 = AppraisalScoreLines::where('appraisal_score_id', $header->id)->where('score', 3)->sum('score');

		$cek1 = AppraisalScoreLines::where('appraisal_score_id', $header->id)
			->where('score', 1)
			->whereIn('appraisal_item_id', [1, 3])
			->count();

		$cek2 = AppraisalScoreLines::where('appraisal_score_id', $header->id)
			->where('score', 1)
			->count();

		if ($sum < 22) {
			$kriteria = 'Buruk';
		} elseif ($sum >= 22 && $sum <= 28) {
			if ($cek1 > 0) {
				$kriteria = 'Buruk';
			} else {
				$kriteria = 'Cukup';
			}
		} elseif ($sum > 28) {
			if ($cek2 > 0) {
				$kriteria = 'Cukup';
			} else {
				$kriteria = 'Sangat Baik';
			}
		}

		$data = [
			'header' => $header,
			'lines' => $lines,
			'sum' => $sum,
			'kriteria' => $kriteria,
			'score1' => $score1,
			'score2' => $score2,
			'score3' => $score3,
		];

		return $data;
	}
	public function store($data)
	{
		$kd = 'PA-'.time();
    $user = $data['user_id'];
    $date_start = '01 ' . $data['date_start'];
    $date_end = '01 ' . $data['date_end'];

		$convert_start = date('Y-m-d', strtotime($date_start));
    $convert_end = date('Y-m-d', strtotime($date_end));

    $get_user = User::find($user);
    $name = $get_user->name;
    $lokasi = $get_user->lokasi_id;
    $department = $get_user->department_id;
    $divisi = $get_user->divisi_id;
    $jabatan = $get_user->jabatan_id;
    $department_jabatan = $get_user->department_jabatan_id;
    $atasan = $get_user->atasan_id;

    $approval = User::find($atasan);
    $approval_name = $approval->name;
    $approval_nohp = $approval->no_hp;

    $manager = get_cuti_setujui($atasan, $lokasi);

		// $no_wa = '085250038002';
		$no_wa = $approval_nohp;
		$pengajuan = 'Performance Appraisal Karyawan';
		$status = 'appraisal_atasan';
		$otp = $this->random_number();
		$encoded = base64_encode(time().'&'.$kd.'&'.$otp.'&'.$atasan.'&'.$status);
		$url = 'approval/appraisal/' . str_replace('=', '', $encoded);
		$teks_otp = "Kode OTP : *".intval($otp)."*";
		$message = whatsappMessage($name, $pengajuan, $approval_name, $kd, $status, '');

		$this->send_wa($no_wa, $url, $message['subject'], $message['message'], $user, $teks_otp);

    $lines = [];

    $data = [
      'kd' => $kd,
      'users_id' => $user,
      'date_start' => $convert_start,
      'date_end' => $convert_end,
      'atasan_id' => $atasan,
      'manager_id' => $manager,
      'lokasi_id' => $lokasi,
      'department_id' => $department,
      'divisi_id' => $divisi,
      'jabatan_id' => $jabatan,
      'department_jabatan_id' => $department_jabatan
    ];

    $post = AppraisalScore::create($data);
    if ($post) {
      $get_lines = AppraisalItem::all();

      foreach ($get_lines as $linesx) {
        $lines[] = [
          'appraisal_score_id' => $post->id,
          'appraisal_key_id' => $linesx->appraisal_key_id,
          'appraisal_item_id' => $linesx->id,
        ];
      }

      AppraisalScoreLines::insert($lines);
    }

		$res = [
			'message' => 'sukses'
		];

		return $res;
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