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
}
