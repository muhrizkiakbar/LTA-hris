<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use App\Models\Dinas;
use App\Services\DinasServices;
use Illuminate\Http\Request;

class DinasController extends Controller
{
  public function __construct(DinasServices $services)
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

		// dd($kd);

		$cek = Dinas::where('kd',$kd)->first();

		if(isset($cek))
		{
			$row = $this->service->detail($kd);

			$header = $row['header'];

			$exp = explode('-', $header->date);
			$thn = $exp[0];
			$bln = $exp[1];

			$view_detail = 'approval.dinas.detail';
			$url_periksa = 'approval.dinas.periksa';
			$url_setuju = 'approval.dinas.setuju';
			$url_ketahui = 'approval.dinas.ketahui';
			$url_otp = 'approval.dinas.otp';
			$url_reject = 'approval.dinas.reject';

			$distrik = $cek->employee->distrik_id;

			if ($distrik=='7') 
			{
				$url_ketahui_trf = 'approval.dinas.ketahui_trf';
			}
			else
			{
				$url_ketahui_trf = null;
			}

			$lines = $row['lines'];

			$data = [
				'title' => 'Perjalanan Dinas',
				'row' => $header,
				'otp' => $otp,
				'status' => $status,
				'thn' => $thn,
				'bln' => $bln,
				'code' => $code,
				'url_periksa' => $url_periksa,
				'url_setuju' => $url_setuju,
				'url_ketahui' => $url_ketahui,
				'url_ketahui_trf' => $url_ketahui_trf,
				'url_otp' => $url_otp,
				'url_reject' => $url_reject,
				'view_detail' => $view_detail,
				'doc' => 'PD',
				'approval' => $header->status,
				'lines' => $lines
			];

			return view('approval.detail')->with($data);
		}
		else
		{
			$data = [
				'title' => 'Perjalanan Dinas',
				'kd' => $kd
			];

			return view('approval.notfound')->with($data);
		}

		
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

		return view('approval.dinas.otp')->with($data);
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

	public function ketahui_trf($code)
	{
		$this->service->ketahui_trf($code);

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

		return view('approval.dinas.reject')->with($data);
	}

	public function reject_update(Request $request)
	{
		$post = $request->all();

		$this->service->reject($post);

		return redirect()->back();
	}
}
