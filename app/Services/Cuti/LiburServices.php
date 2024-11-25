<?php

namespace App\Services\Cuti;

use App\Models\CutiLines;

class LiburServices
{
	public function data()
	{
		$row = CutiLines::where('cuti_type_id',6)
										->whereYear('date',date('Y'))
										->orderBy('date','ASC')
										->get();

		return $row;
	}

	public function post($data)
	{
		$cek = CutiLines::where('date',$data['date'])
										->where('cuti_type_id',6)
										->get();

		if (count($cek) > 0) 
		{
			$result = [
				'message' => 'error'
			];
		}
		else
		{
			$post = [
				'date' => $data['date'],
				'desc' => $data['desc'],
				'cuti_type_id' => 6
			];
	
			CutiLines::create($post);

			$result = [
				'message' => 'sukses'
			];
		}
		
		return $result;
	}

	public function delete($id)
	{
		return CutiLines::find($id)->delete();
	}
}