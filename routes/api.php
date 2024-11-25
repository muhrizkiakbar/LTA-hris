<?php

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Controllers\Api\V1\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [ApiController::class, 'login']);

Route::get('department', [ApiController::class, 'department']);
Route::get('getEmployee', [ApiController::class, 'getEmployee']);
Route::post('slpNumber', [EmployeeController::class, 'slpNumber']);

Route::group(['middleware' => 'auth.jwt'], function () {
  
});
