<?php

namespace App\Http\Controllers\Backend\Cuti;

use App\Http\Controllers\Controller;
use App\Models\CutiHeader;
use App\Models\CutiLines;
use App\Models\User;
use App\Services\Cuti\KhususServices;
use Illuminate\Http\Request;

class KhususController extends Controller
{
  public function __construct(KhususServices $service)
	{
		$this->service = $service;
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

		$data = [
      'title' => 'Cuti Khusus',
			'section' => 'cuti',
			'sub_section' => 'cuti_pengajuan',  
      'assets' => $assets,
			'row' => $row
    ];

		return view('backend.cuti.khusus.index')->with($data);
	}

	public function create(Request $request)
	{
		$row = $this->service->select_create();

		$data = [
      'title' => 'Pengajuan Cuti Khusus',
			'user' => $row['user'],
			'khusus' => $row['khusus']
    ];

		return view('backend.cuti.khusus.create')->with($data);
	}

	public function store(Request $request)
	{
		$data = $request->all();

		$post = $this->service->store($data);

		if ($post['message']=='error_already') 
		{
			$alert = array(
        'type' => 'danger',
        'message' => 'Maaf, tanggal cuti yang anda pilih sedang dalam pengajuan, silahkan cek kembali'
      );
		} 
		else if ($post['message']=='error_already_header')
		{
			$alert = array(
				'type' => 'danger',
				'message' => 'Maaf, Pengajuan cuti sebelumnya masi belum di berikan approval'
			);
		} 
		else if ($post['message']=='error_notfound')
		{
			$alert = array(
				'type' => 'danger',
				'message' => 'Maaf, Department & Divisi karyawan tidak ditemukan, silahkan cek kembali'
			);
		}
		else if ($post['message']=='error_already_exchange')
		{
			$alert = array(
				'type' => 'danger',
				'message' => 'Maaf, pengganti sementara yang anda pilih sedang dalam pengajuan cuti, silahkan cek kembali'
			);
		}
		else
		{
			$alert = array(
				'type' => 'success',
				'message' => 'Data berhasil di diinput'
			);
		}

		return redirect()->back()->with($alert);
	}

	public function detail($kd)
	{
		$assets = array(
			'style' => array(
        'assets/css/loading.css',
				'assets/backend/libs/sweetalert2/sweetalert2.min.css'
      ),
      'script' => array(
        'assets/backend/js/plugins/printArea/jquery.PrintArea.js',
				'assets/backend/libs/sweetalert2/sweetalert2.min.js',
      )
    );

		$get = CutiHeader::where('kd',$kd)->first();
    $date = $get->date;
    $user_id = $get->employee_id;

    $exp = explode('-', $date);
    $thn = $exp[0];
    $bln = $exp[1];

    $employee = User::find($user_id);

    $cuti_lines = CutiLines::where('cuti_header_id', $get->id)->orderBy('date', 'ASC')->pluck('date');

    $str1 = str_replace('["', '', $cuti_lines);
    $str2 = str_replace('"]', '', $str1);
    $str3 = str_replace('","', ', ', $str2);

    $date = explode(', ',$str3);
    $date_count = count($date);

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
			'title' => 'Cuti Khusus - Detail',
			'section' => 'cuti',
			'sub_section' => 'cuti_pengajuan',
			'get' => $get,
			'bln' => $bln,
      'thn' => $thn,
      'employee' => $employee,
      'lines' => $lines,
      'lines_count' => count($cuti_lines),
			'assets' => $assets
		];

		return view('backend.cuti.khusus.detail')->with($data);
	}

	public function periksa(Request $request)
	{
		$kd = $request->id;
		$code = base64_encode(time().'&'.$kd);
		$post = $this->service->periksa($code);

		if ($post['message']=='sukses') 
		{
			$callback = [
				'message' => 'sukses',
				'id' => $kd
			];
		}
		else
		{
			$callback = [
				'message' => 'error'
			];
		}

		echo json_encode($callback);
	}

	public function setuju(Request $request)
	{
		$kd = $request->id;
		$code = base64_encode(time().'&'.$kd);
		$post = $this->service->setuju($code);

		if ($post['message']=='sukses') 
		{
			$callback = [
				'message' => 'sukses',
				'id' => $kd
			];
		}
		else
		{
			$callback = [
				'message' => 'error'
			];
		}

		echo json_encode($callback);
	}

	public function ketahui(Request $request)
	{
		$kd = $request->id;
		$code = base64_encode(time().'&'.$kd);
		$post = $this->service->ketahui($code);

		if ($post['message']=='sukses') 
		{
			$callback = [
				'message' => 'sukses',
				'id' => $kd
			];
		}
		else
		{
			$callback = [
				'message' => 'error'
			];
		}

		echo json_encode($callback);
	}

	public function delete($id)
	{
		$this->service->delete($id);

		$alert = array(
      'type' => 'success',
      'message' => 'Cuti berhasil di hapus'
    );

    return redirect()->back()->with($alert);
	}
}
