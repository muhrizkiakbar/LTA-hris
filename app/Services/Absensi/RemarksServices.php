<?php

namespace App\Services\Absensi;

use App\Models\AbsensiRemarks;
use App\Models\User;
use App\Models\UserLokasi;

class RemarksServices
{
	public function data()
	{
		$role = auth()->user()->role_id;
    $users_id = auth()->user()->id;

		$year = date('Y');

    if ($role == 1 || $role == 2 || $role == 3) 
		{
      $get = AbsensiRemarks::whereYear('date',$year)
														->orderBy('id','DESC')
														->get();
    } 
		else 
		{
      $user_lokasi = UserLokasi::where('users_id', $users_id)->pluck('lokasi_id');
      $get = AbsensiRemarks::select('absensi_remarks.*')
													->leftJoin('users', 'absensi_remarks.users_id', '=', 'users.id')
													->whereYear('absensi_remarks.date',$year)
													->whereIn('users.lokasi_id',$user_lokasi)
													->orderBy('id','DESC')
													->get();
    }

		return $get;
	}

	public function pluck_data()
	{
		$role = auth()->user()->role_id;
    $users_id = auth()->user()->id;

    if ($role == 1 || $role == 2 || $role==3) 
		{
      $user = User::where('role_id', 5)
                 ->whereNull('resign_st')
                 ->pluck('name','id');
    } 
		else 
		{
      $user_lokasi = UserLokasi::where('users_id', $users_id)->pluck('lokasi_id');
      $user = User::where('role_id', 5)
                 ->whereNull('resign_st')
                 ->whereIn('lokasi_id', $user_lokasi)
                 ->pluck('name','id');
    }

		$data = [
			'user' => $user
		];

		return $data;
	}

	public function store($data)
	{
		$name = auth()->user()->email;
    $menu = "Absensi Remarks Karyawan";

		$user = User::find($data['users_id']);

		$date_start = $data['date1'];
		$date_from = date ("Y-m-d", strtotime("-1 day", strtotime($date_start)));
		$date_end = $data['date2'];

		while (strtotime($date_from) < strtotime($date_end)) 
    {
			$date_from = date ("Y-m-d", strtotime("+1 day", strtotime($date_from)));//looping tambah 1 date

			$lines[] = [
				'users_id' => $data['users_id'],
				'date' => $date_from,
				'remarks' => $data['remarks']
			];
		}

    AbsensiRemarks::insert($lines);

		$title = $name;
    $action = '<badge class="badge badge-success">Generate Absensi Remarks</badge>';
    $keterangan = "Input data baru dari menu <b>" . $menu . "</b> dengan nama : <b>" . $user->name . "</b> keterangan : <b>". $data['remarks'] ."</b> , By : <b>" . $name . "</b>";

    history($title, $action, $keterangan);

		$response = [
			'message' => 'sukses'
		];

		return $response;
	}

	public function delete($id)
	{
		$name = auth()->user()->email;
    $menu = "Absensi Remarks Karyawan";

		$get = AbsensiRemarks::find($id);

    $user = User::find($get->users_id);

    AbsensiRemarks::find($id)->delete();

		$title = $name;
    $action = '<badge class="badge badge-danger">Delete Absensi Remarks</badge>';
    $keterangan = "Delete dari menu <b>" . $menu . "</b> dengan nama : <b>" . $user->name . "</b> keterangan : <b>". $get->remarks ."</b> , By : <b>" . $name . "</b>";

    history($title, $action, $keterangan);

		$response = [
			'message' => 'sukses'
		];

		return $response;
	}
}