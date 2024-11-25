<?php

namespace App\Http\Controllers\Approval\Surat;

use App\Http\Controllers\Controller;
use App\Services\Surat\IjinServices;
use Illuminate\Http\Request;

class IjinController extends Controller
{
  public function __construct(IjinServices $services)
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

		if (isset($row)) 
		{
			$exp = explode('-', $row->date);
			$thn = $exp[0];
			$bln = $exp[1];

			$view_detail = 'approval.surat.ijin_detail';
			$url_periksa = 'approval.surat_ijin.periksa';
			$url_setuju = 'approval.surat_ijin.setuju';
			$url_ketahui = 'approval.surat_ijin.ketahui';
			$url_otp = 'approval.surat_ijin.otp';
			$url_reject = 'approval.surat_ijin.reject';

			$data = [
				'title' => 'Surat Ijin Meninggalkan Tempat Kerja',
				'row' => $row,
				'otp' => $otp,
				'status' => $status,
				'thn' => $thn,
				'bln' => $bln,
				'code' => $code,
				'url_periksa' => $url_periksa,
				'url_setuju' => $url_setuju,
				'url_ketahui' => $url_ketahui,
				'url_otp' => $url_otp,
				'url_reject' => $url_reject,
				'view_detail' => $view_detail,
				'doc' => 'SIM',
				'approval' => $row['status']
			];

			return view('approval.detail')->with($data);
		}
		else
		{
			$data = [
				'title' => 'Surat Ijin Meninggalkan Tempat Kerja',
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

		return view('approval.surat.ijin_otp')->with($data);
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

		return view('approval.surat.ijin_reject')->with($data);
	}

	public function reject_update(Request $request)
	{
		$post = $request->all();

		$this->service->reject($post);

		return redirect()->back();
	}

}
