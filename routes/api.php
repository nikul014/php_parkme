<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Modules\Users\UserController;

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

$strDefaultPath = 'App\Http\Controllers\Modules\test@defaultResponse';
Route::get('/',$strDefaultPath);

Route::get('/login',[UserController::class,'login']);
Route::post('/addUserDetails',[UserController::class,'addUserDetails']);

Route::middleware('ParkingAuth')->group(function (){
    Route::get('/get_users',[UserController::class,'getUsers']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
