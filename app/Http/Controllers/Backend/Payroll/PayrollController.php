<?php

namespace App\Http\Controllers\Backend\Payroll;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Distrik;
use App\Models\Payroll;
use App\Models\PayrollLines;
use App\Services\Payroll\PayrollServices;
use Illuminate\Http\Request;
use Spatie\SimpleExcel\SimpleExcelWriter;

class PayrollController extends Controller
{
	public function __construct(PayrollServices $services)
	{
		$this->service = $services;
	}

  public function index()
	{
		$role = auth()->user()->role_id;

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

		$row =  $this->service->data();

		$distrik = Distrik::pluck('title','id');

		$data = [
      'title' => 'Generate Payroll',
			'section' => 'payroll',
			'sub_section' => 'payroll_generate',  
      'assets' => $assets,
			'row' => $row,
			'distrik' => $distrik,
			'role' => $role
    ];

		return view('backend.payroll.generate.index')->with($data);
	}

	public function store(Request $request)
	{
		$post = $this->service->store($request->all());

		if ($post['info']=='success') 
		{
			$alert = array(
				'type' => 'success',
				'message' => 'Payroll berhasil generate'
			);
		}
		elseif($post['info']=='unauthorized')
		{
			$alert = array(
				'type' => 'success',
				'message' => 'Maaf, Anda tidak memiliki otoritas !'
			);
		}
		else
		{
			$alert = array(
				'type' => 'danger',
				'message' => 'Maaf, terjadi kesalahan, silahkan cek kembali'
			);
		}

		return redirect()->back()->with($alert);
	}

	public function detail($id)
	{
		$assets = array(
      'style' => array(
				'assets/backend/css/loading.css',
				'assets/backend/libs/select2/css/select2.min.css',
				'assets/js/plugins/air-datepicker/css/datepicker.min.css',
				'assets/backend/css/custom.css'
			),
			'script' => array(
				'assets/backend/libs/select2/js/select2.min.js',
				'assets/js/plugins/notifications/sweet_alert.min.js',
				'assets/js/plugins/air-datepicker/js/datepicker.min.js',
				'assets/js/plugins/air-datepicker/js/i18n/datepicker.en.js',
				'assets/backend/libs/freeze-panes/dist/js/freeze-table.js'
			)
		);

		$department = Department::orderBy('title','ASC')
														->pluck('title','id');

		$data = [
			'title' => 'Detail Payroll',
			'section' => 'payroll',
			'sub_section' => 'payroll_generate',  
			'department' => $department,
			'payroll_id' => $id,
			'assets' => $assets
		];

		return view('backend.payroll.detail.index')->with($data);

	}

	public function detail_view(Request $request)
	{
		$department = $request->department;
		$payroll_id = $request->payroll_id;

		$header = Payroll::find($payroll_id);

		if ($header->lock==1) 
		{
			$view = 'backend.payroll.detail.view_lock';
		}
		else
		{
			$view = 'backend.payroll.detail.view';
		}

		$row = $this->service->payroll_lines($department, $payroll_id);

		$data = [
			'row' => $row
		];

		return view($view)->with($data);
	}

	function detail_update(Request $request)
	{
		$data = $request->all();

		$this->service->update_payroll($data);

		$alert = array(
			'type' => 'success',
			'message' => 'Detail payroll berhasil di update !'
		);

		return redirect()->back()->with($alert);
	}

	public function lock($id)
	{
		$role = auth()->user()->role_id;

		if ($role==1 || $role==3) 
		{
			$data = [
				'lock' => 1
			];

			Payroll::find($id)->update($data);

			$alert = array(
				'type' => 'success',
				'message' => 'Payroll berhasil di update !'
			);
		} 
		else
		{
			$alert = array(
				'type' => 'success',
				'message' => 'Maaf, Anda tidak memiliki otoritas !'
			);
		}

		return redirect()->back()->with($alert);
	}

	public function unlock($id)
	{
		$role = auth()->user()->role_id;

		if ($role==1 || $role==3) 
		{
			$data = [
				'lock' => 0
			];

			Payroll::find($id)->update($data);

			$alert = array(
				'type' => 'success',
				'message' => 'Payroll berhasil di update !'
			);
		} 
		else
		{
			$alert = array(
				'type' => 'success',
				'message' => 'Maaf, Anda tidak memiliki otoritas !'
			);
		}

		return redirect()->back()->with($alert);
	}

	public function delete($id)
	{
		$role = auth()->user()->role_id;

		if ($role==1 || $role==3) 
		{
			$data = [
				'lock' => 0
			];

			Payroll::find($id)->delete();
			PayrollLines::where('payroll_id',$id)->delete();

			$alert = array(
				'type' => 'danger',
				'message' => 'Payroll berhasil di hapus !'
			);
		} 
		else
		{
			$alert = array(
				'type' => 'success',
				'message' => 'Maaf, Anda tidak memiliki otoritas !'
			);
		}

		return redirect()->back()->with($alert);
	}

	public function export(Request $request)
	{
		$payroll_id = $request->get('payroll_id');

		$payroll = Payroll::find($payroll_id);

		$distrik = $payroll->distrik->title;

		$periode = str_replace(' ','_',$payroll->periode);

		$row = $this->service->export($payroll_id);

		SimpleExcelWriter::streamDownload('LTA_PAYROLL_'.$periode.'_'.$distrik.'_'.time().'.xlsx')->addRows($row['data']);
	}
}
