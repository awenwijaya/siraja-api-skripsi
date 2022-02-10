<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengguna;
use App\Models\Penduduk;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\Dusun;
use Illuminate\Support\Facades\DB;

class PendudukController extends Controller
{
    public function __construct(){
        $this->Penduduk = new Penduduk;
        $this->Pengguna = new Pengguna;
        $this->Desa = new Desa;
    }

    public function showDataDusunByDesaId() {
        Request()->validate([
            'desa_id' => 'required'
        ]);
        $dusun = Dusun::select()->where('desa_id', Request()->desa_id)->get();
        return response()->json([
            'status' => 'OK',
            'message' => 'Data Dusun Berhasil Didapatkan!',
            'data' => $dusun
        ]);
    }

    public function userProfile($id) {
        $data = Penduduk::join('tb_sso', 'tb_sso.penduduk_id', '=', 'tb_penduduk.penduduk_id')
                        ->join('tb_desa', 'tb_desa.desa_id', '=', 'tb_penduduk.desa_id')
                        ->join('tb_pekerjaan', 'tb_pekerjaan.pekerjaan_id', '=', 'tb_penduduk.pekerjaan_id')
                        ->where('tb_penduduk.penduduk_id', $id)
                        ->first();
        return response()->json($data);
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
        $username_pengguna = Pengguna::select('username')->where('user_id', Request()->user_id)->first();
        $data_username = json_decode($username_pengguna);
        $cek_username = Pengguna::select('username')->where('username', Request()->username)->first();
        if($data_username->username != Request()->username) {
            if($cek_username != null) {
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Username sudah terdaftar sebelumnya'
                ], 501);
            }else{
                $this->Pengguna->EditProfile($data_user, Request()->user_id);
                $this->Penduduk->EditPenduduk($data_penduduk, Request()->penduduk_id);
                return response()->json([
                    'status' => 'Success',
                    'message' => 'Profil Berhasil Diubah!'
                ], 200);
            } 
        }else{
            $this->Pengguna->EditProfile($data_user, Request()->user_id);
            $this->Penduduk->EditPenduduk($data_penduduk, Request()->penduduk_id);
            return response()->json([
                'status' => 'Success',
                'message' => 'Profil Berhasil Diubah!'
            ], 200);
        }
        
    }

    public function showDataDesaById($id) {
        $data = Desa::join('tb_kecamatan', 'tb_kecamatan.kecamatan_id', '=', 'tb_desa.kecamatan_id')
                    ->where('desa_id', $id)
                    ->first();
        return response()->json($data, 200);
    }

    public function showDataKecamatanById() {
        Request()->validate([
            'kecamatan_id' => 'required'
        ]);
        $data = [
            'kecamatan_id' => Request()->kecamatan_id
        ];
        $data_kecamatan = Kecamatan::select()->where('kecamatan_id', Request()->kecamatan_id)->first();
        return response()->json($data_kecamatan, 200);
    }

    public function countPendudukDesa($id) {
        dd($id);
        // Request()->validate([
        //     'desa_id' => 'required'
        // ]);
        $data = Penduduk::where([
            ['desa_id', '=', $id],
            ['status_penduduk', '=', 'Aktif']
        ])->count();
        return response()->json($data, 200);
    }

    public function countDusun() {
        Request()->validate([
            'desa_id' => 'required'
        ]);
        $data = Dusun::where('desa_id', Request()->desa_id)->count();
        return response()->json($data, 200);
    }
}
