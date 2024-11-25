<?php

namespace App\Services\Employee;

use App\Models\Belting;
use App\Models\KlasifikasiTraining;
use App\Models\Lokasi;
use App\Models\Training;
use App\Models\TrainingLines;
use App\Models\User;

class TrainingServices
{
	public function select_index()
	{
		$klasifikasi = KlasifikasiTraining::pluck('title','id');

		$result = [
			'klasifikasi' => $klasifikasi
		];

		return $result;
	}

	public function search($data)
	{
		$header = Training::find($data['training']);
		$row = TrainingLines::where('training_id',$data['training'])
												->get();

		$result = [
			'header' => $header,
			'row' => $row
		];

		return $result;
	}

	public function select_create()
	{
		$peserta = User::where('role_id', 5)->pluck('name', 'id');
    $lokasi = Lokasi::pluck('title', 'id');
    $klasifikasi = KlasifikasiTraining::pluck('title', 'id');

		$result = [
			'klasifikasi' => $klasifikasi,
			'lokasi' => $lokasi,
			'peserta' => $peserta
		];

		return $result;
	}

	public function select_detail($id)
	{
		$data = TrainingLines::find($id);
    $belting = Belting::pluck('title','id');

		$result = [
			'data' => $data,
			'belting' => $belting
		];

		return $result;
	}
}