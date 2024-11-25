<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserLokasi;
use Illuminate\Support\Facades\Hash;

class UserServices 
{
	public function data()
	{
		return User::whereIn('role_id', [1, 3, 4, 7, 8, 10,11])->get();
	}

	public function store($request)
	{
		$get_last = User::whereIn('role_id',[3, 4, 7, 8, 10,11])->orderBy('nik','DESC')->limit(1)->first();

		$nik = $get_last->nik + 1;

		$lokasi = $request['lokasi_id'];

		$data = [
      'nik' => $nik,
      'name' => $request['name'],
      'email' => $request['email'],
      'password' => Hash::make($request['password']),
      'role_id' => $request['role_id']
    ];

		$post = User::create($data);
    if ($post) 
		{
      if (!empty($lokasi)) 
			{
        foreach ($lokasi as $item) {
          $data2 = [
            'users_id' => $post->id,
            'lokasi_id' => $item
          ];

          UserLokasi::create($data2);
        }
      }
    }

		$result = [
			'message' => 'sukses'
		];

    return $result;
	}
}