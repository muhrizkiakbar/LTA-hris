<?php

namespace App\Services\Master;

use App\Models\DinasLokasiJarak;

class DinasLokasiServices 
{
	public function data()
	{
		return DinasLokasiJarak::get();
	}

	public function detail($id)
	{
		return DinasLokasiJarak::find($id);
	}
}