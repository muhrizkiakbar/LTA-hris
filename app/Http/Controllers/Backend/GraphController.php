<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\BackendServices;
use Illuminate\Http\Request;

class GraphController extends Controller
{
  public function chart_kontrak()
	{
		$service = new BackendServices;

		$data = $service->group_kontrak();

		return response()->json($data);
	}

	public function chart_karyawan_gender()
	{
		$service = new BackendServices;

		$data = $service->karyawan_gender();

		return response()->json($data);
	}

	public function chart_range_ages()
	{
		$service = new BackendServices;

		$data = $service->range_ages();

		return response()->json($data);
	}

	public function chart_absensi()
	{
		$service = new BackendServices;

		$data = $service->chart_absensi();

		return response()->json($data);
	}
}
