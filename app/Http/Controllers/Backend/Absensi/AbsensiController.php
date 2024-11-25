<?php

namespace App\Http\Controllers\Backend\Absensi;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Employee;
use App\Models\Lokasi;
use App\Services\Absensi\AbsensiServices;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
	public function __construct(AbsensiServices $services)
	{
		$this->service = $services;
	}

	public function index()
	{
		$assets = [
      'style' => array(
				'assets/backend/libs/select2/css/select2.min.css',
        'assets/backend/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css',
				'assets/backend/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css',
				'assets/js/plugins/air-datepicker/css/datepicker.min.css'
      ),
      'script' => array(
				'assets/backend/libs/select2/js/select2.min.js',
        'assets/backend/libs/datatables.net/js/jquery.dataTables.min.js',
				'assets/backend/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js',
				'assets/js/plugins/air-datepicker/js/datepicker.min.js',
				'assets/js/plugins/air-datepicker/js/i18n/datepicker.en.js'
      )
    ];

		$row = $this->service->data();

		$mesin = [
			'0' => 'Manual Absensi',
      '1' => 'Secure Fingerprint',
      '2' => 'FingerSpot',
      '3' => 'FingerSpot V2 (TRK, GRG)',
      '4' => 'Solution Fingerprint',
      '5' => 'FingerSpot V3 (SPT)',
			'6' => 'FingerSpot V4 (PKY)',
			'7' => 'Solution Fingerprint V2 (BRB)'
    ];

		$data = [
      'title' => 'Absensi Karyawan',
			'section' => 'absensi',
			'sub_section' => 'absensi_karyawan',  
      'assets' => $assets,
			'row' => $row,
			'mesin' => $mesin
    ];

		return view('backend.absensi.index')->with($data);
	}

	public function generate(Request $request)
	{
		$excel = $request->file('file');
    $mesin = $request->mesin;

		$post = $this->service->import($excel, $mesin);

		if ($post['message']=='sukses') 
		{
			$alert = array(
        'type' => 'success',
        'message' => 'Absen berhasil di generate'
      );
		}
		else
		{
			$alert = array(
        'type' => 'error',
        'message' => 'Maaf terjadi kesalahan, silahkan cek kembali'
      );
		}

		return redirect()->back()->with($alert);
	}

	public function delete(Request $request)
	{
		$lokasi = Lokasi::pluck('title','id');

		$data = [
      'title' => 'Delete Absensi Karyawan',
			'lokasi' => $lokasi
    ];

		return view('backend.absensi.delete')->with($data);
	}

	public function delete_absensi(Request $request)
	{
		$periode = $request->periode;
		$lokasi = $request->lokasi_id;

		$date = explode(' - ',$periode);

		$date1 = date('Y-m-d',strtotime($date[0]));
    $date2 = date('Y-m-d',strtotime($date[1]));

		$user_active = Employee::where('lokasi_id',$lokasi)
													 ->whereNull('resign_st')
													 ->pluck('nik');


		// dd($user_active);

		Absensi::whereIn('nik',$user_active)
					 ->where('date','>=',$date1)
					 ->where('date','<=',$date2)
					 ->delete();


		$alert = array(
			'type' => 'success',
			'message' => 'Absen berhasil di hapus'
		);

		return redirect()->back()->with($alert);
	}
}
