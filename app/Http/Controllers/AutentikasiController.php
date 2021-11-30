<?php

namespace App\Http\Controllers;

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
        $hasil_cek = $this->Penduduk->CekPenduduk(Request()->nik);
        if($hasil_cek == null) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Data penduduk tidak ditemukan'
            ], 500);
        }else{
            return response()->json([
                'status' => 'OK',
                'message' => 'Data penduduk ditemukan'
            ], 200);
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
        $data = $this->Penduduk->CekPenduduk(Request()->nik);
        return response()->json([
            'status' => 'OK',
            'message' => 'Data penduduk ditemukan',
            $data
        ]);
    }

    public function login(){
        Request()->validate(
            [
                'email' => 'required',
                'password' => 'required'
            ]
        );
        $cek = $this->Pengguna->Login(Request()->email, Request()->password);
        if($cek == null){
            return response()->json([
                'status' => 'Failed',
                'message' => 'Pastikan Anda memasukkan email dan password yang benar'
            ], 500);
        }else{
            return response()->json([
                'status' => 'Success',
                'message' => 'Login berhasil'
            ], 200);
        }
    }
}
