<?php

namespace App\Services\Employee;

use App\Models\Vaksin;

class VaksinServices
{
	public function data($users_id)
	{
		return Vaksin::where('users_id',$users_id)
								 ->orderBy('id','DESC')
								 ->get();
	}
}