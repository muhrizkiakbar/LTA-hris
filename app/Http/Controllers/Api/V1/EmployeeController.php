<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
  public function slpNumber(Request $request)
	{
		$data = $request->all();

    $sales_code = $data['sales_code'];

		$row = User::where('sales_code',$sales_code)->first();

		if (isset($row)) 
		{
			return response()->json([
				'success' => true,
				'number'  => $row->no_hp
			]);
		}
		else
		{
			return response()->json([
				'success' => false,
				'number'  => NULL
			]);
		}
	}
}
