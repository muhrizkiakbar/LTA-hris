<?php

namespace App\Http\Controllers\Approval\Surat;

use App\Http\Controllers\Controller;
use App\Services\Surat\TugasServices;
use Illuminate\Http\Request;

class TugasController extends Controller
{
  public function __construct(TugasServices $services)
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

		$view_detail = 'approval.surat.tugas_detail';
		$url_periksa = 'approval.surat_tugas.periksa';
		$url_setuju = 'approval.surat_tugas.setuju';
		$url_ketahui = 'approval.surat_tugas.ketahui';
		$url_otp = 'approval.surat_tugas.otp';
		$url_reject = 'approval.surat_tugas.reject';

		$data = [
			'title' => 'Surat Tugas',
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
			'doc' => 'ST',
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

		return view('approval.surat.tugas_otp')->with($data);
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

		return view('approval.surat.tugas_reject')->with($data);
	}

	public function reject_update(Request $request)
	{
		$post = $request->all();

		$this->service->reject($post);

		return redirect()->back();
	}
}
