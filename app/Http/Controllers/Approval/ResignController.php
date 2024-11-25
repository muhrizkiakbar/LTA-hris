<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\ResignInterviewScore;
use App\Models\User;
use App\Services\Employee\EmployeeServices;
use Illuminate\Http\Request;

class ResignController extends Controller
{
	public function interview($code)
	{
		$service = new EmployeeServices;

		$url_decode = base64_decode($code);
    $exp = explode('&',$url_decode);

		$users_id = $exp[1];
		$otp = $exp[2];
		$status = 'resign_interview';

		$score = $service->interview_score($users_id);

		// dd($score);

		$user = User::find($users_id);

		$exp = explode('-', date('Y-m-d'));
    $thn = $exp[0];
    $bln = $exp[1];

		$data = [
			'title' => 'Exit Interview - Karyawan Resign',
			'otp' => $otp,
			'status' => $status,
			'thn' => $thn,
			'bln' => $bln,
			'doc' => 'EXIT-INTERVIEW',
			'score' => $score,
			'row' => $user,
			'code' => $code,
			'users_id' => $users_id,
			'resign_interview_st' => $user->resign_interview_st
		];

		return view('approval.resign.interview')->with($data);
	}

	public function interview_otp(Request $request)
	{
		$code = $request->code;
		$url_decode = base64_decode($code);
    $exp = explode('&',$url_decode);

		$otp = $exp[2];

		$data = [
			'otp' => $otp
		];

		return view('approval.resign.otp')->with($data);
	}

	public function interview_store(Request $request)
	{
		// dd($request->all());

		$id = $request->id;
    $idx = $request->idx;
    $score = $request->check;
		$users_id = $request->users_id;
		$code = $request->code;

		$data = [];

		foreach ($id as $key) 
		{
			if ($idx[$key]==5) 
			{
				$data = [
					'score' => $score[4]
				];
			}
			else
			{
				$data = [
					'score' => $score[$key]
				];
			}
			
			ResignInterviewScore::where('users_id',$users_id)
													->where('resign_interviews_id',$idx[$key])
													->update($data);
    }

		// $user = User::find($users_id);

		// $wa_no = '085250038002';
		// $pengajuan = 'Exit Clearance Form';
		// $status = 'resign_clearance';
		// $otp = $this->random_number();
		// $encoded = base64_encode(time().'&'.$users_id.'&'.$otp);
    // $url = 'resign/clearance/' . str_replace('=', '', $encoded);
		// $teks_otp = "Kode OTP : *".intval($otp)."*";
		// $message = whatsappMessage($user->name, $pengajuan, '', $users_id, $status, '');

		// $this->send_wa($wa_no, $url, $message['subject'], $message['message'], $users_id, $teks_otp);

		$user_data = [
			'resign_interview_st' => 1,
			'resign_clearance_st' => 1,
			'resign_statuses_id' => 1
		];

		Employee::find($users_id)->update($user_data);

		return redirect()->route('resign.interview',$code);
	}

	public function send_wa($no_hp, $url, $subject, $new_message, $users_id, $teks_otp)
	{
		$no_wa = '085250038002';
		// $no_wa = $no_hp;
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
