<?php

namespace App\Http\Controllers\Approval\Cuti;

use App\Http\Controllers\Controller;
use App\Models\CutiLines;
use App\Services\Cuti\KhususServices;
use Illuminate\Http\Request;

class KhususController extends Controller
{
  public function __construct(KhususServices $services)
	{
		$this->service = $services;
	}

	public function index($code)
	{
		$url_decode = base64_decode($code);
    $exp = explode('&',$url_decode);

		$kd = $exp[1];
		$otp = $exp[2];
		$status = isset($exp[4]) ? $exp[4] : '';

		$row = $this->service->detail($kd);

		$exp = explode('-', $row->date);
    $thn = $exp[0];
    $bln = $exp[1];

		$cuti_lines = CutiLines::where('cuti_header_id', $row->id)->orderBy('date', 'ASC')->pluck('date');

		$str1 = str_replace('["', '', $cuti_lines);
    $str2 = str_replace('"]', '', $str1);
    $str3 = str_replace('","', ', ', $str2);

    $date = explode(', ',$str3);
    $date_count = count($date);

		$view_detail = 'approval.cuti.khusus_detail';
		$url_periksa = 'approval.cuti_khusus.periksa';
		$url_setuju = 'approval.cuti_khusus.setuju';
		$url_ketahui = 'approval.cuti_khusus.ketahui';
		$url_otp = 'approval.cuti_khusus.otp';
		$url_reject = 'approval.cuti_khusus.reject';

    $lines = "";
    for ($i=0; $i < $date_count ; $i++) 
    {
      $nox = $i;
      if($nox==$date_count-1)
      {
        $sepa = "";
      } 
      else
      {
        $sepa = ", ";
      }

      $lines .= tgl_def($date[$i]).$sepa;
    }

		$data = [
			'title' => 'Cuti Khusus',
			'row' => $row,
			'otp' => $otp,
			'status' => $status,
			'thn' => $thn,
			'bln' => $bln,
			'code' => $code,
			'lines' => $lines,
      'lines_count' => count($cuti_lines),
			'url_periksa' => $url_periksa,
			'url_setuju' => $url_setuju,
			'url_ketahui' => $url_ketahui,
			'url_otp' => $url_otp,
			'url_reject' => $url_reject,
			'view_detail' => $view_detail,
			'doc' => 'CK',
			'approval' => $row['approval']
		];

		return view('approval.detail')->with($data);
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

		return view('approval.cuti.khusus_otp')->with($data);
	}

	public function periksa($code)
	{
		$this->service->periksa($code);

		return redirect()->back();
	}

	public function setuju($code)
	{
		$this->service->setuju($code);

		return redirect()->back();
	}

	public function ketahui($code)
	{
		$this->service->ketahui($code);

		return redirect()->back();
	}

	public function reject(Request $request)
	{
		$code = $request->code;
		$url_decode = base64_decode($code);
    $exp = explode('&',$url_decode);

		$kd = $exp[1];
		$approval = $exp[3];

		$data = [
			'kd' => $kd,
			'approval' => $approval
		];

		return view('approval.cuti.khusus_reject')->with($data);
	}

	public function reject_update(Request $request)
	{
		$post = $request->all();

		$this->service->reject($post);

		return redirect()->back();
	}
}
