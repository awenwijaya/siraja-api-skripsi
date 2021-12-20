<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutentikasiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('forgetpassword/{email}', [AutentikasiController::class, 'showForgetPasswordPage']);
Route::post('forgetpassword/reset/{email}', [AutentikasiController::class, 'resetPassword'])->name('reset.password');
