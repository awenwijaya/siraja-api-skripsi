<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Pengguna;
use App\Models\Penduduk;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;

class AutentikasiController extends Controller
{

    public function __construct(){
        $this->Penduduk = new Penduduk;
        $this->Pengguna = new Pengguna;
    }

    public function cek_penduduk(){
        Request()->validate(
            [
                'nik' => 'required'
            ]
        );
        $hasil_cek = Penduduk::select()->where('nik', Request()->nik)->first();
        if($hasil_cek == null) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Data penduduk tidak ditemukan'
            ], 500);
        }else{
            return response()->json($hasil_cek, 200);
        }
    }

    public function get_data_penduduk_nik(){
        Request()->validate(
            [
                'nik' => 'required'
            ],
            [
                'nik.required' => 'Data NIK penduduk belum diisi'
            ]
        );
        $nama_lengkap = Penduduk::select()->where('nik', Request()->nik)->first();
        return response()->json($nama_lengkap, 200);
    }

    public function login(){
        Request()->validate(
            [
                'email' => 'required',
                'password' => 'required'
            ]
        );
        $password = Pengguna::select('password')->where('email', Request()->email)->first();
        $data_pengguna = Pengguna::select()->where('email', Request()->email)->first();
        $password_decode = json_decode($password);
        if($password != ""){
            if(Hash::check(Request()->password, $password_decode->password)) {
                return response()->json($data_pengguna, 200);
            } else {
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Password salah'
                ], 500) ;
            }
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Email salah'
            ], 500);
        }
    }

    public function registrasi(){
        Request()->validate([
            'username' => 'required',
            'nomor_telepon' => 'required',
            'email' => 'required',
            'password' => 'required',
            'id_desa' => 'required',
            'penduduk_id' => 'required',
        ]);

        $cek_email = Pengguna::select('email')->where('email', Request()->email)->first();
        $cek_nomor_telepon = Pengguna::select('nomor_telepon')->where('nomor_telepon', Request()->nomor_telepon)->first();
        $cek_username = Pengguna::select('username')->where('username', Request()->username)->first();

        $data = [
            'username' => Request()->username,
            'email' => Request()->email,
            'password' => Hash::make(Request()->password),
            'nomor_telepon' => Request()->nomor_telepon,
            'role' => 'Pengguna',
            'penduduk_id' => Request()->penduduk_id,
            'desa_id' => Request()->id_desa,
            'is_verified' => "Not Verified"
        ];

        if($cek_email != null || $cek_nomor_telepon != null || $cek_username != null) {
            return response()->json([
                'status' => 'Failed',
                'messages' => 'Email, nomor telepon, atau username sudah terdaftar sebelumnya'
            ], 501);
        } else {
            $this->Pengguna->Register($data);
            return response()->json([
                'status' => 'OK',
                'message' => 'Registrasi Akun Berhasil'
            ], 200);
        }
    }

    public function cekemail() {
        Request()->validate([
            'email' => 'required'
        ]);
        $cek_email = Pengguna::select('email')->where('email', Request()->email)->first();
        if($cek_email != null) {
            return response()->json([
                'status' => 'OK',
                'messages' => 'Email pengguna ditemukan'
            ], 200);
        }else{
            return response()->json([
                'status' => 'Failed',
                'messages' => 'Email pengguna tidak ditemukan'
            ], 500);
        }
    }

    public function showForgetPasswordPage($email) {
        $cek_email = Pengguna::select('email')->where('email', $email)->first();
        $dataemail = [];
        if($cek_email != null) {
            $dataemail = [
                'email' => $email
            ];
            return view('forgetpassword', compact('cek_email'));
        }else{
            return view('emailnotfound');
        }
    }

    public function resetPassword($email) {
        Request()->validate([
            'password' => 'required',
            'confirm_password' => 'required'
        ], [
            'password.required' => 'Password baru belum terisi',
            'confirm_password.required' => 'Konfirmasi password belum terisi'
        ]);

        $data = [
            'password' => Hash::make(Request()->password)
        ];

        $this->Pengguna->ResetPassword($data, $email);
        return response()->json([
            'status' => 'OK',
            'messages' => 'Password berhasil diubah!'
        ], 200);
    }
}
