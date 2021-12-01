<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Pengguna;
use App\Models\Penduduk;

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
        if($password != ""){
            if(Hash::check(Request()->password, $password)) {
                return response()->json([
                    'status' => 'OK',
                    'message' => 'Anda berhasil login!'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Password salah'
                ], 500);
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

        $data = [
            'username' => Request()->username,
            'email' => Request()->email,
            'password' => Hash::make(Request()->password),
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
