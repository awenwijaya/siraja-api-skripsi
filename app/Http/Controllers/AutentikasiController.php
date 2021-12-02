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
        $password_encrypt = Crypt::decryptString($password);
        $pengguna = Pengguna::select()->where('email', Request()->email)->first();
        if($password == "" || $password == null) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Email salah'
            ], 500);
        }else if($password_encrypt != Request()->password){
            return response()->json([
                'status' => 'Failed',
                'message' => 'Password salah'
            ], 500);
        }else{
            return response()->json($pengguna, 200);
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

        $data = [
            'username' => Request()->username,
            'email' => Request()->email,
            'password' => Request()->password,
            'nomor_telepon' => Request()->nomor_telepon,
            'role' => 'Pengguna',
            'penduduk_id' => Request()->penduduk_id,
            'desa_id' => Request()->id_desa
        ];

        $this->Pengguna->Register($data);
        return response()->json([
            'status' => 'OK',
            'message' => 'Registrasi Akun Berhasil'
        ], 200);

    }
}
