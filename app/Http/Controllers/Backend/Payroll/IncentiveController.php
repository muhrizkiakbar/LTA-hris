<?php

namespace App\Http\Controllers\Backend\Payroll;

use App\Http\Controllers\Controller;
use App\Models\PayrollIncentive;
use App\Models\PayrollLines;
use App\Services\Payroll\PayrollServices;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;

class IncentiveController extends Controller
{
  public function __construct(PayrollServices $services)
	{
		$this->service = $services;
	}

	public function index()
	{
		$assets = [
      'style' => array(
        'assets/backend/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css',
				'assets/backend/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css',
				'assets/js/plugins/air-datepicker/css/datepicker.min.css'
      ),
      'script' => array(
        'assets/backend/libs/datatables.net/js/jquery.dataTables.min.js',
				'assets/backend/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js',
				'assets/js/plugins/air-datepicker/js/datepicker.min.js',
				'assets/js/plugins/air-datepicker/js/i18n/datepicker.en.js'
      )
    ];

		$row =  PayrollIncentive::orderBy('id','DESC')->get();

		$data = [
      'title' => 'Payroll Incentive & PPH 21',
			'section' => 'payroll',
			'sub_section' => 'payroll_incentive', 
      'assets' => $assets,
			'row' => $row
    ];

		return view('backend.payroll.incentive.index')->with($data);
	}

	public function store(Request $request)
	{
		// dd($request->all());

		$periode = $request->input('periode');

		$filename = $request->file('file')->getClientOriginalName();
		$request->file('file')->storeAs('public/upload/csv', $filename);
		$path = public_path('storage/upload/csv/'.$filename);

		$collection = (new FastExcel)->import($path);

		// dd($collection);

		$incentive_reg = 0;
		$incentive_gm = 0;
		$principal = 0;
		$trf15 = 0;
		$thr = 0;
		$potongan_batal_nota = 0;

		if (count($collection) > 0) 
		{
			foreach ($collection as $line) 
			{
				$gaji = PayrollLines::where('periode',$periode)
														->where('nik',$line['nik'])
														->first();

				// $incentive_reg = $this->checkIncentiveReg($line['incentive_reg'],  $gaji->incentive_reg);

				// dd($incentive_reg);

				if (isset($gaji)) 
				{
					$incentive_reg = $this->checkIncentiveReg($line['incentive_reg'],  $gaji->incentive_reg);
					$incentive_gm = $this->checkIncentiveGm($line['incentive_gm'],  $gaji->incentive_gm);
					$principal = $this->checkKlaimPrincipal($line['klaim_principal'], $gaji->principal);
					$trf15 = $this->checkTrf15($line['trf15'], $gaji->trf15);
					$pph21 = $this->checkPph21($line['pph21'], $gaji->potongan_pph21);
					$pinjaman =  $this->checkPinjaman($line['pinjaman'], $gaji->potongan_pinjaman);
					$thr = $this->checkThr($line['thr'], $gaji->thr);
					$potongan_batal_nota = $this->checkPotonganBatalNota($line['potongan_batal_nota'], $gaji->potongan_batal_nota);

					$gaji_full_pendapatan = isset($gaji->full_pendapatan) ? $gaji->full_pendapatan : 0;

					$full_pendapatan = $gaji_full_pendapatan + $incentive_reg + $incentive_gm + $principal + $trf15 + $thr;
					$full_potongan = $gaji->full_potongan + ($pph21 + $pinjaman + $potongan_batal_nota);

					$total_trf = $full_pendapatan - $full_potongan;

					$data = [
						'incentive_reg' => $incentive_reg,
						'incentive_gm' => $incentive_gm,
						'principal' => $principal,
						'nama_principal_klaim' => $line['nama_principal_klaim'],
						'trf15' => $trf15,
						'thr' => $thr,
						'full_pendapatan' => $full_pendapatan,
						'potongan_pph21' => $pph21,
						'potongan_pinjaman' => $pinjaman,
						'potongan_batal_nota' => $potongan_batal_nota,
						'full_potongan' => $full_potongan,
						'total_trf' => $total_trf
					];

					PayrollLines::where('periode',$periode)
											->where('nik',$line['nik'])
											->update($data);
				}
			}

			$header = [
				'periode' => $periode
			];

			PayrollIncentive::create($header);

			$alert = array(
				'type' => 'success',
				'message' => 'Payroll incentive berhasil di upload'
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

	public function delete($id)
	{
		$data = PayrollIncentive::find($id);

		$get = PayrollLines::where('periode',$data->periode)->get();

		foreach ($get as $line) 
		{
			$full_pendapatan = $line->full_pendapatan - ($line->incentive_reg+$line->incentive_gm+$line->principal+$line->trf15);
			$full_potongan = $line->full_potongan - ($line->potongan_pph21 + $line->potongan_pinjaman);

			$total_trf = $full_pendapatan - $full_potongan;

			$data2 = [
				'incentive_reg' => 0,
				'incentive_gm' => 0,
				'principal' => 0,
				'nama_principal_klaim' => NULL,
				'trf15' => 0,
				'full_pendapatan' => $full_pendapatan,
				'potongan_pph21' => 0,
				'potongan_pinjaman' => 0,
				'full_potongan' => $full_potongan,
				'total_trf' => $total_trf
			];

			PayrollLines::where('periode',$data->periode)
									->where('nik',$line['nik'])
									->update($data2);
		}

		PayrollIncentive::find($id)->delete();

		$alert = array(
			'type' => 'success',
			'message' => 'Payroll incentive berhasil di hapus'
		);

		return redirect()->back()->with($alert);	
	}

	public function checkIncentiveReg($incentive_reg, $gaji_incentive_reg)
	{
		if (!empty($incentive_reg) || $incentive_reg != 0 || $incentive_reg != '') 
		{
			return empty($incentive_reg) ? 0 : $incentive_reg;
		}
		else
		{
			return isset($gaji_incentive_reg) ? $gaji_incentive_reg : 0 ;
		}
	}

	public function checkIncentiveGm($incentive_gm, $gaji_incentive_gm)
	{
		if (!empty($incentive_gm) || $incentive_gm != 0 || $incentive_gm != '') 
		{
			return empty($incentive_gm) ? 0 : $incentive_gm;
		}
		else
		{
			return isset($gaji_incentive_gm) ? $gaji_incentive_gm : 0 ;
		}
	}

	public function checkKlaimPrincipal($klaim_principal, $principal)
	{
		if (!empty($klaim_principal) || $klaim_principal != 0 || $klaim_principal != '') 
		{
			return empty($klaim_principal) ? 0 : $klaim_principal;
		}
		else
		{
			return isset($principal) ? $principal : 0 ;
		}
	}

	public function checkTrf15($trf15, $gaji_trf15)
	{
		if (!empty($trf15) || $trf15 != 0 || $trf15 != '') 
		{
			return empty($trf15) ? 0 : $trf15;
		}
		else
		{
			return isset($gaji_trf15) ? $gaji_trf15 : 0 ;
		}
	}

	public function checkPph21($pph21, $gaji_pph21)
	{
		if (!empty($pph21) || $pph21 != 0 || $pph21 != '') 
		{
			return empty($pph21) ? 0 : $pph21;
		}
		else
		{
			return isset($gaji_pph21) ? $gaji_pph21 : 0 ;
		}
	}

	public function checkPinjaman($pinjaman, $gaji_pinjaman)
	{
		if (!empty($pinjaman) || $pinjaman != 0 || $pinjaman != '') 
		{
			return empty($pinjaman) ? 0 : $pinjaman;
		}
		else
		{
			return isset($gaji_pinjaman) ? $gaji_pinjaman : 0 ;
		}
	}

	public function checkThr($thr, $gaji_thr)
	{
		if (!empty($thr) || $thr != 0 || $thr != '') 
		{
			return empty($thr) ? 0 : $thr;
		}
		else
		{
			return isset($gaji_thr) ? $gaji_thr : 0 ;
		}
	}

	public function checkPotonganBatalNota($potongan_batal_nota, $gaji_potongan_batal_nota)
	{
		if (!empty($potongan_batal_nota) || $potongan_batal_nota != 0 || $potongan_batal_nota != '') 
		{
			return empty($potongan_batal_nota) ? 0 : $potongan_batal_nota ;
		}
		else
		{
			return isset($gaji_potongan_batal_nota) ? $gaji_potongan_batal_nota : 0 ;
		}
	}
}
