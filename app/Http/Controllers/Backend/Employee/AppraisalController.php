<?php

namespace App\Http\Controllers\Backend\Employee;

use App\Http\Controllers\Controller;
use App\Models\AppraisalItem;
use App\Models\AppraisalScore;
use App\Models\AppraisalScoreLines;
use App\Models\User;
use App\Services\Employee\AppraisalServices;
use Illuminate\Http\Request;

class AppraisalController extends Controller
{
	public function index(Request $request)
	{
		$assets = [
      'style' => array(
        'assets/css/loading.css',
				'assets/backend/libs/select2/css/select2.min.css',
      ),
      'script' => array(
				'assets/backend/libs/select2/js/select2.min.js',
        'assets/js/plugins/notifications/sweet_alert.min.js',
      )
    ];

		$data = [
      'title' => 'Surat Peringatan',
			'section' => 'karyawan',
			'sub_section' => 'surat_peringatan',
			'assets' => $assets,
			'id' => $request->id
		];

		return view('backend.employee.detail.appraisal')->with($data);
	}

	public function store(Request $request)
	{
		$service = new AppraisalServices;

		$post = $service->store($request->all());

		if ($post['message']=='sukses') 
		{
			$alert = array(
				'type' => 'info',
				'message' => 'Data berhasil di generate'
			);
		}

    return redirect()->route('backend.employee.detail', $request->user_id)->with($alert);
	}

	public function view($id)
	{
		$assets = array(
      'script' => array(
        'assets/js/plugins/rowspanizer/jquery.rowspanizer.min.js'
      )
    );

		$header = AppraisalScore::find($id);
		$lines = AppraisalScoreLines::where('appraisal_score_id', $id)->get();
    $sum = AppraisalScoreLines::where('appraisal_score_id', $id)->sum('score');

    $score1 = AppraisalScoreLines::where('appraisal_score_id', $id)->where('score', 1)->sum('score');
    $score2 = AppraisalScoreLines::where('appraisal_score_id', $id)->where('score', 2)->sum('score');
    $score3 = AppraisalScoreLines::where('appraisal_score_id', $id)->where('score', 3)->sum('score');

		$cek1 = AppraisalScoreLines::where('appraisal_score_id', $id)
      ->where('score', 1)
      ->whereIn('appraisal_item_id', [1, 3])
      ->count();

    $cek2 = AppraisalScoreLines::where('appraisal_score_id', $id)
      ->where('score', 1)
      ->count();

    if ($sum < 22) {
      $kriteria = 'Buruk';
    } elseif ($sum >= 22 && $sum <= 28) {
      if ($cek1 > 0) {
        $kriteria = 'Buruk';
      } else {
        $kriteria = 'Cukup';
      }
    } elseif ($sum > 28) {
      if ($cek2 > 0) {
        $kriteria = 'Cukup';
      } else {
        $kriteria = 'Sangat Baik';
      }
    }

		$data = [
			'title' => 'Detail Performance Appraisal',
			'section' => 'karyawan',
			'sub_section' => 'data_karyawan',
			'header' => $header,
      'lines' => $lines,
      'sum' => $sum,
      'kriteria' => $kriteria,
      'score1' => $score1,
      'score2' => $score2,
      'score3' => $score3,
			'assets' => $assets
		];

		return view('backend.employee.detail.appraisal_view')->with($data);
	}

	public function delete($id)
	{
		AppraisalScore::find($id)->delete();
		AppraisalScoreLines::where('appraisal_score_id', $id)->delete();

		$alert = array(
			'type' => 'info',
			'message' => 'Data berhasil di hapus'
		);

		return redirect()->back()->with($alert);
	}
}
