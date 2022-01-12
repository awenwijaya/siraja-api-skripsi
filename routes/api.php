<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutentikasiController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\SKPendudukController;

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
Route::post('cekemail', [AutentikasiController::class, 'cekemail']);
Route::post('lupapassword', [EmailController::class, 'kirimEmailLupaPassword']);

//profile
Route::post('editprofile', [PendudukController::class, 'editProfile']);

//data
Route::post('getdatapendudukbyid', [PendudukController::class, 'showDataPendudukById']);
Route::post('getdatadesabyid', [PendudukController::class, 'showDataDesaById']);
Route::post('getdatapenggunabyid', [PendudukController::class, 'showDataUserById']);
Route::post('getdatakecamatanbyid', [PendudukController::class, 'showDataKecamatanById']);
Route::post('countpenduduk', [PendudukController::class, 'countPendudukDesa']);
Route::post('countdusun', [PendudukController::class, 'countDusun']);

//sk belum menikah
Route::post('sk/belumnikah/ceknikah', [SKPendudukController::class, 'cek_nikah']);
Route::post('sk/belumnikah/up', [SKPendudukController::class, 'up_sk_belum_nikah']);

//sp penghasilan orang tua
Route::post('/sp/penghasilanortu/getdataortu', [SKPendudukController::class, 'get_data_orang_tua']);
Route::post('/sp/penghasilanortu/up', [SKPendudukController::class, 'up_sp_penghasilan_ortu']);

//sk kelakuan baik
Route::post('/sk/kelakuanbaik/up', [SKPendudukController::class, 'up_sk_kelakuan_baik']);