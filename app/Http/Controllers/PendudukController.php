<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengguna;
use App\Models\Penduduk;
use App\Models\Desa;

class PendudukController extends Controller
{
    public function __construct(){
        $this->Penduduk = new Penduduk;
        $this->Pengguna = new Pengguna;
        $this->Desa = new Desa;
    }

    public function showDataPendudukById() {
        Request()->validate([
            'penduduk_id' => 'required'
        ]);
        $hasil_penduduk = Penduduk::select()->where('penduduk_id', Request()->penduduk_id)->first();
        return response()->json($hasil_penduduk, 200);
    }

    public function showDataDesaById() {
        Request()->validate([
            'desa_id' => 'required'
        ]);
        $data_desa = Desa::select()->where('desa_id', Request()->desa_id)->first();
        return response()->json($data_desa, 200);
    }

    public function showDataUserById() {
        Request()->validate([
            'user_id' => 'required'
        ]);
        $data_pengguna = Pengguna::select()->where('user_id', Request()->user_id)->first();
        return response()->json($data_pengguna, 200);
    }

    public function editProfile() {
        Request()->validate([
            'user_id' => 'required',
            'penduduk_id' => 'required',
            'username' => 'required',
            'alamat' => 'required',
            'agama' => 'required',
            'status_perkawinan' => 'required',
            'pendidikan_terakhir' => 'required'
        ]);
        $data_user = [
            'username' => Request()->username
        ];
        $data_penduduk = [
            'alamat' => Request()->alamat,
            'agama' => Request()->agama,
            'alamat' => Request()->alamat,
            'status_perkawinan' => Request()->status_perkawinan,
            'pendidikan_terakhir' => Request()->pendidikan_terakhir
        ];
        $cek_username = Pengguna::select('username')->where('username', Request()->username)->first();
        if($cek_username != null) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Username sudah terdaftar sebelumnya'
            ], 501);
        }else{
            $this->Pengguna->EditProfile($data_user, Request()->user_id);
            $this->Penduduk->EditPenduduk($data_penduduk, Request()->penduduk_id);
            return response()->json([
                'status' => 'OK',
                'message' => 'Data profil berhasil diubah'
            ], 200);
        }
    }
}
