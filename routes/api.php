<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutentikasiController;
use App\Http\Controllers\EmailController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//autentikasi
Route::post('cek_penduduk', [AutentikasiController::class, 'cek_penduduk']);
Route::post('getdatabynik', [AutentikasiController::class, 'get_data_penduduk_nik']);
Route::post('login', [AutentikasiController::class, 'login']);
Route::post('registrasi', [AutentikasiController::class, 'registrasi']);
Route::post('konfirmasiemail', [EmailController::class, 'index']);
Route::get('verifyemail/{email}', [EmailController::class, 'konfirmasiemail']);
