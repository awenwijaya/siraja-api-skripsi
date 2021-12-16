<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
use App\Mail\EmailLupaPassword;
use App\Models\Pengguna;
use Carbon\Carbon;

class EmailController extends Controller
{

    public function __construct(){
        $this->Pengguna = new Pengguna;
    }

    public function index() {
        Request()->validate([
            'email' => 'required'
        ]);
        $email_tujuan = Request()->email;
        $data = [
            'email' => $email_tujuan
        ];
        Mail::to(Request()->email)->send(new SendEmail($data));
        return response()->json([
            'status' => 'OK',
            'message' => 'Konfirmasi Email berhasil Dikirimkan!'
        ], 200);
    }

    public function konfirmasiEmail($email) {
        $timestamp = Carbon::now()->toDateTimeString();
        $data = [
            'email_verified_at' => $timestamp,
            'is_verified' => 'Verified'
        ];
        $this->Pengguna->KonfirmasiEmail($data, $email);
        return response()->json([
            'status' => 'OK',
            'message' => 'Email berhasil dikonfirmasi'
        ]);
    }

    public function kirimEmailLupaPassword() {
        Request()->validate([
            'email' => 'required'
        ]);
        $email_tujuan = Request()->email;
        $pengguna = Pengguna::select()->where('email', Request()->email)->first();
        $pengguna_decode = json_decode($pengguna);
        $data = [
            'email' => $email_tujuan,
            'nama' => $pengguna_decode->username
        ];
        Mail::to(Request()->email)->send(new EmailLupaPassword($data));
        return response()->json([
            'status' => 'OK',
            'message' => 'Email lupa password berhasil dikirimkan!'
        ], 200);
    }
}
