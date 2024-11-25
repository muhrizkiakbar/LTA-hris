<?php

namespace App\Services\Master;

use App\Models\DinasLokasiJarak;
use App\Models\DinasUangExcept;

class DinasExceptServices 
{
	public function data()
	{
		return DinasUangExcept::orderBy('id','DESC')->get();
	}

	public function detail($id)
	{
		return DinasUangExcept::find($id);
	}
}