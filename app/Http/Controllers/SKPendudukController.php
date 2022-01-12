<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penduduk;
use App\Models\SKBelumMenikah;
use Carbon\Carbon;
use App\Models\SuratMasyarakat;
use Illuminate\Support\Facades\DB;
use App\Models\DetailPenduduk;
use App\Models\SPPenghasilanOrtu;
use App\Models\SKKelakuanBaik;

class SKPendudukController extends Controller
{
    public function __construct(){
        $this->Penduduk = new Penduduk;
        $this->SKBelumMenikah = new SKBelumMenikah;
        $this->SuratMasyarakat = new SuratMasyarakat;
        $this->DetailPenduduk = new DetailPenduduk;
        $this->SPPenghasilanOrtu = new SPPenghasilanOrtu;
        $this->SKKelakuanBaik = new SKKelakuanBaik;
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

    public function get_data_orang_tua() {
        Request()->validate([
            'penduduk_id' => 'required'
        ]);
        $kartu_keluarga_id = DetailPenduduk::select('kartu_keluarga_id')->where('penduduk_id', Request()->penduduk_id)->first();
        $data_kartu_keluarga_id = json_decode($kartu_keluarga_id);
        $data_orang_tua = DetailPenduduk::join('tb_penduduk', 'tb_detail_penduduk.penduduk_id', '=', 'tb_penduduk.penduduk_id')
                                        ->whereIn('status_keluarga', ['Istri', 'Kepala Keluarga'])
                                        ->where('kartu_keluarga_id', $data_kartu_keluarga_id->kartu_keluarga_id)
                                        ->get();
        return response()->json([
            'status' => 'OK',
            'message' => 'Data Orang Tua Ditemukan',
            'data' => $data_orang_tua
        ]);
    }

    public function up_sp_penghasilan_ortu() {
        Request()->validate([
            'nama_orang_tua' => 'required',
            'penduduk_id' => 'required',
            'jumlah_penghasilan' => 'required',
            'keperluan' => 'required',
            'desa_id' => 'required'
        ]);
        $id_orang_tua = Penduduk::select('penduduk_id')->where('nama_lengkap', Request()->nama_orang_tua)->first();
        $data_id_orang_tua = json_decode($id_orang_tua);
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
            'surat_masyarakat_id' => $last_surat_masyarakat_id,
            'orang_tua_id' => $data_id_orang_tua->penduduk_id,
            'jumlah_penghasilan' => Request()->jumlah_penghasilan
        ];
        $this->SPPenghasilanOrtu->UpSPPenghasilanOrtu($data);
        return response()->json([
            'status' => 'OK',
            'message' => 'Pengajuan SP Penghasilan Orang Tua Berhasil!'
        ], 200);
    }

    public function up_sk_kelakuan_baik() {
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
        $this->SKKelakuanBaik->UpSKKelakuanBaik($data);
        return response()->json([
            'status' => 'OK',
            'message' => 'Pengajuan SK Kelakuan Baik Berhasil!'
        ], 200);
    }
}