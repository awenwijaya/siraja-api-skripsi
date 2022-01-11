<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penduduk;
use App\Models\SKBelumMenikah;
use Carbon\Carbon;
use App\Models\SuratMasyarakat;
use Illuminate\Support\Facades\DB;

class SKPendudukController extends Controller
{
    public function __construct(){
        $this->Penduduk = new Penduduk;
        $this->SKBelumMenikah = new SKBelumMenikah;
        $this->SuratMasyarakat = new SuratMasyarakat;
    }

    public function cek_nikah() {
        Request()->validate([
            'penduduk_id' => 'required'
        ]);
        $hasil_nikah = Penduduk::select('status_perkawinan')->where('penduduk_id', Request()->penduduk_id)->first();
        return response()->json($hasil_nikah);
    }
    
    public function up_sk_belum_nikah() {
        Request()->validate([
            'penduduk_id' => 'required',
            'keperluan' => 'required',
            'desa_id' => 'required'
        ]);
        $timestamp = Carbon::now()->toDateTimeString();
        $data_surat_masyarakat = [
            'tanggal_pengajuan' => $timestamp,
            'desa_id' => Request()->desa_id
        ];
        $last_surat_masyarakat_id = DB::table('tb_surat_masyarakat')->insertGetId($data_surat_masyarakat);
        $data = [
            'penduduk_id' => Request()->penduduk_id,
            'status' => 'Menunggu Respons',
            'keperluan' => Request()->keperluan,
            'surat_masyarakat_id' => $last_surat_masyarakat_id
        ];
        $this->SKBelumMenikah->UpSKBelumMenikah($data);
        return response()->json([
            'status' => 'OK',
            'message' => 'Pengajuan SK Belum Menikah Berhasil!'
        ], 200);
    }
}
