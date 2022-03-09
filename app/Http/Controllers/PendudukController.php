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
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

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
            'username' => 'required',
            'password' => 'required',
            'password_sekarang' => 'required'
        ]);
        $data_user = [
            'username' => Request()->username,
            'password' => Hash::make(Request()->password),
        ];
        $username_pengguna = Pengguna::select()->where('user_id', Request()->user_id)->first();
        $data_username = json_decode($username_pengguna);
        $cek_username = Pengguna::select('username')->where('username', Request()->username)->first();
        if(Hash::check(Request()->password_sekarang, $data_username->password)) {
            if($data_username->username == Request()->username) {
                $this->Pengguna->EditProfile($data_user, Request()->user_id);
                return response()->json([
                    'status' => 'Success',
                    'message' => 'Profil Berhasil Diubah!'
                ], 200);
            }else{
                if($cek_username != null) {
                    return response()->json([
                        'status' => 'Failed',
                        'message' => 'Username sudah terdaftar sebelumnya'
                    ], 501);
                }else{
                    $this->Pengguna->EditProfile($data_user, Request()->user_id);
                    return response()->json([
                        'status' => 'Success',
                        'message' => 'Profil Berhasil Diubah!'
                    ], 200);
                }
                
            }
        }else{
            return response()->json([
                'status' => 'Failed',
                'message' => 'Password Salah!'
            ], 502);
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

    public function show_all_penduduk_by_desa_id($id) {
        $data = Penduduk::select()->where('desa_id', $id)->get();
        return response()->json([
            'status' => 'OK',
            'message' => 'Data berhasil didapatkan!',
            'data' => $data
        ], 200);
    }
}
