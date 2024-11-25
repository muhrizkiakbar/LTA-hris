<?php

namespace App\Services\Employee;

use App\Models\Konseling;

class KonselingServices
{
	public function data($users_id)
	{
		return Konseling::where('users_id',$users_id)
										->orderBy('id','DESC')
										->get();
	}
}