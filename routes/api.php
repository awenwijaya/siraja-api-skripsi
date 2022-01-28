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
Route::post('dusun', [PendudukController::class, 'showDataDusunByDesaId']);

//sk belum menikah
Route::post('sk/belumnikah/showSedangDiproses', [SKPendudukController::class, 'show_sk_belum_menikah_sedang_proses']);
Route::post('sk/belumnikah/showSelesai', [SKPendudukController::class, 'show_sk_belum_menikah_selesai']);
Route::post('sk/belumnikah/ceknikah', [SKPendudukController::class, 'cek_nikah']);
Route::post('sk/belumnikah/up', [SKPendudukController::class, 'up_sk_belum_nikah']);
Route::post('sk/belumnikah/cancel', [SKPendudukController::class, 'cancel_sk_belum_menikah']);

//sp penghasilan orang tua
Route::post('sp/penghasilanortu/getdataortu', [SKPendudukController::class, 'get_data_orang_tua']);
Route::post('sp/penghasilanortu/up', [SKPendudukController::class, 'up_sp_penghasilan_ortu']);

//sk kelakuan baik
Route::post('sk/kelakuanbaik/up', [SKPendudukController::class, 'up_sk_kelakuan_baik']);
Route::post('sk/kelakuanbaik/showSedangDiproses', [SKPendudukController::class, 'show_sk_kelakuan_baik_sedang_proses']);
Route::post('sk/kelakuanbaik/showSelesai', [SKPendudukController::class, 'show_sk_kelakuan_baik_selesai']);
Route::post('sk/kelakuanbaik/cancel', [SKPendudukController::class, 'cancel_sk_kelakuan_baik']);

//sk tempat usaha
Route::post('sk/tempatusaha/up', [SKPendudukController::class, 'up_sk_tempat_usaha']);
Route::post('sk/tempatusaha/showSedangDiproses', [SKPendudukController::class, 'show_sk_tempat_usaha_sedang_proses']);
Route::post('sk/tempatusaha/showSelesai', [SKPendudukController::class, 'show_sk_tempat_usaha_selesai']);

//sk usaha
Route::post('sk/usaha/gettempatusaha', [SKPendudukController::class, 'get_tempat_usaha_by_penduduk_id']);