<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PosisiController;
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

//public route
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

//protec sanctum route
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('posisi/add', [PosisiController::class, 'store']);
    Route::get('posisi', [PosisiController::class, 'get_list']);
    Route::get('posisi/{id}', [PosisiController::class, 'show']);
    Route::put('posisi/{id}', [PosisiController::class, 'update']);
    Route::delete('posisi/{id}', [PosisiController::class, 'destroy']);

    Route::post('logout', [AuthController::class, 'logout']);
    
});

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
 */