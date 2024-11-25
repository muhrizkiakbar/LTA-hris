<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use App\Models\AppraisalScore;
use App\Models\AppraisalScoreLines;
use App\Models\User;
use App\Services\Employee\AppraisalServices;
use Illuminate\Http\Request;

class AppraisalController extends Controller
{
  public function index($code)
	{
		$service = new AppraisalServices;

		$url_decode = base64_decode($code);
    $exp = explode('&',$url_decode);

		$kd = $exp[1];
		$otp = $exp[2];
		$status = isset($exp[4]) ? $exp[4] : '';

		$row = $service->detail($kd);

		// dd($row);

		$header = $row['header'];

		if ($header->atasan_st==0) 
		{
			$url_store = 'approval.appraisal.atasan';
		}
		else
		{
			$url_store = 'approval.appraisal.manager';
		}

		$url = $url_store;

		// dd($status);

		$data = [
			'title' => 'Performance Appraisal',
			'otp' => $otp,
			'status' => $status,
			'code' => $code,
			'atasan_st' => isset($header->atasan_st) ? $header->atasan_st : 0,
			'manager_st' => isset($header->manager_st) ? $header->manager_st : 0,
			'url_store' => $url,
			'header' => $header,
			'lines' => $row['lines'],
			'sum' => $row['sum'],
			'kriteria' => $row['kriteria'],
			'score1' => $row['score1'],
			'score2' => $row['score2'],
			'score3' => $row['score3'],
		];

		// dd($data);

		return view('approval.appraisal.index')->with($data);
	}

	public function otp(Request $request)
	{
		$code = $request->code;
		$url_decode = base64_decode($code);
    $exp = explode('&',$url_decode);

		$otp = $exp[2];

		$data = [
			'otp' => $otp
		];

		return view('approval.appraisal.otp')->with($data);
	}

	public function atasan(Request $request)
	{
		// dd($request->all());

		$service = new AppraisalServices;

		$id_no = $request->id;
    $idx = $request->idx;
    $score = $request->check;
    $appraisal_score_id = $request->appraisal_score_id;
    $url = $request->code;

    $url_decode = base64_decode($url);
    $exp = explode('&',$url_decode);
    $kd = $exp[1];

    $get = AppraisalScore::where('kd',$kd)->first();
    $users = $get->users_id;
    $id = $get->id;
    $atasan = $get->manager_id;

    $get_user = User::find($users);
    $name = $get_user->name;

    $approval = User::find($atasan);
    $approval_name = $approval->name;
    $approval_nohp = $approval->no_hp;

		// $no_wa = '085250038002';
		$no_wa = $approval_nohp;
		$pengajuan = 'Performance Appraisal Karyawan';
		$status = 'appraisal_manager';
		$otp = $service->random_number();
		$encoded = base64_encode(time().'&'.$kd.'&'.$otp.'&'.$atasan.'&'.$status);
		$url = 'approval/appraisal/' . str_replace('=', '', $encoded);
		$teks_otp = "Kode OTP : *".intval($otp)."*";
		$message = whatsappMessage($name, $pengajuan, $approval_name, $kd, $status, '');

		$service->send_wa($no_wa, $url, $message['subject'], $message['message'], $users, $teks_otp);

		$data = [];

    foreach ($id_no as $key) {
      if(isset($score[$key]))
      {
        $data = [
          'score' => $score[$key]
        ];
  
        AppraisalScoreLines::where('id', $idx[$key])->update($data);
      }
    }

    $data_header = [
      'review_atasan' => $request->review_atasan,
			'atasan_st' => 1
    ];

    AppraisalScore::where('id',$appraisal_score_id)->update($data_header);

		return redirect()->back();
	}

	public function manager(Request $request)
	{
		$appraisal_score_id = $request->appraisal_score_id;

    $data_header = [
      'review_manager' => $request->review_manager,
			'manager_st' => 1
    ];

    AppraisalScore::where('id',$appraisal_score_id)->update($data_header);
		
		return redirect()->back();
	}
}
