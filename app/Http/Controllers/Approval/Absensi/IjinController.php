<?php

namespace App\Http\Controllers\Approval\Absensi;

use App\Http\Controllers\Controller;
use App\Models\AbsensiIjin;
use App\Services\Absensi\IjinServices;
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
			$exp = explode('-',$row->date_start);
			$thn = $exp[0];
			$bln = $exp[1];

			$data = [
				'title' => 'Absensi Ijin',
				'otp' => $otp,
				'row' => $row,
				'tipe' => $row->absensi_ijin_type_id,
				'bln' => $bln,
				'thn' => $thn,
				'code' => $code,
				'status' => $status,
				'approval' => $row['status']
			];

			return view('approval.absensi.ijin')->with($data);
		}
		else
		{
			$data = [
				'title' => 'Absensi Ijin',
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

		return view('approval.absensi.ijin_otp')->with($data);
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

		return view('approval.absensi.ijin_reject')->with($data);
	}

	public function reject_update(Request $request)
	{
		$post = $request->all();

		$this->service->reject($post);

		return redirect()->back();
	}
}
