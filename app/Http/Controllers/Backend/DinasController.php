<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Dinas;
use App\Models\DinasBiayaTol;
use App\Models\DinasKendaraan;
use App\Models\DinasLokasiJarak;
use App\Models\DinasTempKendaraan;
use App\Models\DinasUang;
use App\Models\Lokasi;
use App\Models\User;
use App\Services\DinasServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File as FacadesFile;

class DinasController extends Controller
{
  public function __construct(DinasServices $services)
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

		$data = [
      'title' => 'Perjalanan Dinas',
			'section' => 'perjalanan',
      'assets' => $assets,
			'row' => $row
    ];

		return view('backend.dinas.index')->with($data);
	}

	public function create()
	{
		$role = auth()->user()->role_id;
    $users_id = auth()->user()->id;

		$assets = [
      'style' => array(
				'assets/backend/libs/select2/css/select2.min.css',
        'assets/js/plugins/air-datepicker/css/datepicker.min.css'
      ),
      'script' => array(
        'assets/js/plugins/notifications/sweet_alert.min.js',
        'assets/backend/libs/select2/js/select2.min.js',
				'assets/js/plugins/air-datepicker/js/datepicker.min.js',
				'assets/js/plugins/air-datepicker/js/i18n/datepicker.en.js'
      )
    ];

		$select = $this->service->pluck_data();

		$data = [
      'title' => 'Tambah Data - Perjalanan Dinas',
			'section' => 'dinas',
			'sub_section' => 'dinas_data',
      'assets' => $assets,
			'employee' => $select['user'],
			'lokasi' => $select['lokasi'],
			'tipe' => $select['tipe'],
			'bool' => $select['bool'],
			'bool2' => $select['bool2'],
			'atasan' => $select['atasan'],
    ];

		return view('backend.dinas.create')->with($data);
	}

	public function info()
	{
		$row = DinasUang::get();

    $data = [
      'row' => $row
    ];
    
    return view('backend.dinas.info')->with($data);
	}

	public function kendaraan_view()
	{
		$row = $this->service->kendaraan_view();

    $data = [
      'row' => $row
    ];

		return view('backend.dinas.kendaraan_table')->with($data);
	}

	public function kendaraan(Request $request)
	{
		$users_id = auth()->user()->id;

    $kendaraan = DinasKendaraan::pluck('title','id');
    $bool = [
      '1' => 'Ya',
      '2' => 'Tidak'
    ];

    $lokasi = Lokasi::pluck('title','id');
    $tol = DinasBiayaTol::pluck('title','id');

    $data = [
      'users_id' => $users_id,
      'kendaraan' => $kendaraan,
      'bool' => $bool,
      'lokasi' => $lokasi,
      'tol' => $tol
    ];

		return view('backend.dinas.kendaraan')->with($data);
	}

	public function kendaraan_store(Request $request)
	{
		$post = $request->all();

		$this->service->kendaraan_store($post);

		return redirect()->back();
	}

	public function kendaraan_delete($id)
	{
		DinasTempKendaraan::find($id)->delete();

		return redirect()->back();
	}

	public function lokasi_jarak(Request $request)
	{
		$lokasi_asal_id = $request->lokasi_asal_id;
    $lokasi_tujuan_id = $request->lokasi_tujuan_id;

    if(empty($lokasi_asal_id) ||  empty($lokasi_tujuan_id))
    {
      $response = [
        'info'=>0
      ];
    }
    else
    {
      $get = DinasLokasiJarak::where('lokasi_asal_id',$lokasi_asal_id)
                              ->where('lokasi_tujuan_id',$lokasi_tujuan_id)
                              ->get();
      
      if(count($get)==0)
      {
        $response = [
          'info'=>0
        ];
      }
      else
      {
        foreach ($get as $value) 
        {
          $jarak = $value->jarak;
        }

        $response = [
          'info' => 1,
          'jarak' => $jarak
        ];
      }
    }

    echo json_encode($response);
	}

	public function store(Request $request)
	{
		$post = $request->all();

		$store = $this->service->store($post);

		if ($store['message']=='empty_kendaraan') 
		{
			$alert = array(
        'type' => 'danger',
        'message' => 'Maaf, Data kendaraan belum di isi'
      );

			return redirect()->back()->with($alert);	
		}
		elseif ($store['message']=='empty_department')
		{
			$alert = array(
        'type' => 'danger',
        'message' => 'Maaf, Department & Divisi karyawan tidak ditemukan, silahkan cek kembali'
      );

			return redirect()->back()->with($alert);	
		}
		else
		{
			$alert = array(
        'type' => 'success',
        'message' => 'Data berhasil di diinput'
      );

			return redirect()->route('backend.dinas.detail',$store['dinas_id'])->with($alert);	
		}		
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

		$detail = $this->service->detail($kd);

		$header = $detail['header'];

		// dd($header);

		$exp = explode('-', $header->date);
    $thn = $exp[0];
    $bln = $exp[1];

		$employee = User::find($header->users_id);

		$lines = $detail['lines'];

		$data = [
      'title' => 'Detail - Perjalanan Dinas',
      'section' => 'dinas',
			'sub_section' => 'dinas_data',
      'bln' => $bln,
      'thn' => $thn,
      'employee' => $employee,
      'assets' => $assets,
      'get' => $header,
      'lines' => $lines
    ];

		return view('backend.dinas.detail')->with($data);

	}

	public function delete($id)
	{
		$this->service->delete($id);

		$alert = array(
			'type' => 'success',
			'message' => 'Data berhasil di di hapus'
		);

		return redirect()->back()->with($alert);
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

	public function ketahui_trf(Request $request)
	{
		$kd = $request->id;
		$code = base64_encode(time().'&'.$kd);
		$post = $this->service->ketahui_trf($code);

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

	public function detail_payment(Request $request)
	{
		$kd = $request->id;

		$detail = $this->service->detail($kd);

		$header = $detail['header'];
		$lines = $detail['lines'];

		$data = [
			'get' => $header,
      'lines' => $lines
		];

		return view('backend.dinas.payment_detail')->with($data);
	}

	public function update_payment(Request $request)
	{
		$id = $request->id;

		$data = Dinas::find($id);

		$data = [
			'get' => $data
		];

		return view('backend.dinas.payment_update')->with($data);
	}

	public function update_payment_store(Request $request)
	{
		$payment = $request->dinas_payment_id;

		$dinas = Dinas::find($request->id);
		$nik =  $dinas->employee->nik;

		if ($payment==1) 
		{
			$payment_proof = $request->file('dinas_payment_proof');

			$input['imagename'] = 'payment_proof_'.$dinas->kd.'_'.time() . '.' . $payment_proof->extension();
      $path = public_path('/storage/upload/employee/' . $nik . '/');
      if (!FacadesFile::isDirectory($path)) {
        FacadesFile::makeDirectory($path, 0777, true, true);
      }

			$payment_proof->move($path, $input['imagename']);
      $origin = $input['imagename'];

			$data = [
				'dinas_payment_id' => 2,
				'dinas_payment_proof' => $origin
			];

			Dinas::find($request->id)->update($data);
		}
		elseif($payment==2)
		{
			$payment_proof = $request->file('dinas_payment_done');

			$input['imagename'] = 'payment_done_'.$dinas->kd.'_'.time() . '.' . $payment_proof->extension();
      $path = public_path('/storage/upload/employee/' . $nik . '/');
      if (!FacadesFile::isDirectory($path)) {
        FacadesFile::makeDirectory($path, 0777, true, true);
      }

			$payment_proof->move($path, $input['imagename']);
      $origin = $input['imagename'];

			$data = [
				'dinas_payment_id' => 3,
				'dinas_payment_done' => $origin
			];

			Dinas::find($request->id)->update($data);
		}

		$alert = array(
			'type' => 'success',
			'message' => 'Data berhasil di di input'
		);

		return redirect()->back()->with($alert);
	}
}
