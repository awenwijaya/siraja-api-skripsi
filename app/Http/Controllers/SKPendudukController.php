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
use App\Models\TempatUsaha;
use App\Models\SKTempatUsaha;
use App\Models\Dusun;

class SKPendudukController extends Controller
{
    public function __construct(){
        $this->Penduduk = new Penduduk;
        $this->SKBelumMenikah = new SKBelumMenikah;
        $this->SuratMasyarakat = new SuratMasyarakat;
        $this->DetailPenduduk = new DetailPenduduk;
        $this->SPPenghasilanOrtu = new SPPenghasilanOrtu;
        $this->SKKelakuanBaik = new SKKelakuanBaik;
        $this->TempatUsaha = new TempatUsaha;
        $this->SKTempatUsaha = new SKTempatUsaha;
        $this->Dusun = new Dusun;
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

    public function up_sk_tempat_usaha() {
        Request()->validate([
            'nama_tempat_usaha' => 'required',
            'alamat' => 'required',
            'jenis_usaha' => 'required',
            'nama_dusun' => 'required',
            'penduduk_id' => 'required',
            'desa_id' => 'required'
        ]);
        $id_dusun = Dusun::select('dusun_id')->where('nama_dusun', Request()->nama_dusun)->first();
        $data_id_dusun = json_decode($id_dusun);
        $data_tempat_usaha = [
            'nama_usaha' => Request()->nama_tempat_usaha,
            'jenis_usaha' => Request()->jenis_usaha,
            'alamat_usaha' => Request()->alamat,
            'dusun_id' => $data_id_dusun->dusun_id,
            'penduduk_id' => Request()->penduduk_id,
        ];
        $last_tempat_usaha_id = DB::table('tb_tempat_usaha')->insertGetId($data_tempat_usaha);
        $timestamp = Carbon::now()->toDateTimeString();
        $data_surat_masyarakat = [
            'tanggal_pengajuan' => $timestamp,
            'desa_id' => Request()->desa_id,
        ];
        $last_surat_masyarakat_id = DB::table('tb_surat_masyarakat')->insertGetId($data_surat_masyarakat);
        $data = [
            'pemohon_id' => Request()->penduduk_id,
            'id_tempat_usaha' => $last_tempat_usaha_id,
            'surat_masyarakat_id' => $last_surat_masyarakat_id,
            'status' => 'Menunggu Respons'
        ];
        $this->SKTempatUsaha->UpSKTempatUsaha($data);
        return response()->json([
            'status' => 'OK',
            'message' => 'Pengajuan SK Tempat Usaha Berhasil!'
        ], 200);
    }

    public function get_tempat_usaha_by_penduduk_id() {
        Request()->validate([
            'penduduk_id' => 'required'
        ]);
        $data_tempat_usaha = TempatUsaha::select()->where('penduduk_id', Request()->penduduk_id)->get();
        return response()->json([
            'status' => 'OK',
            'message' => 'Data Tempat Usaha Ditemukan!',
            'data' => $data_tempat_usaha
        ]);
    }

    public function show_sk_belum_menikah_sedang_proses() {
        Request()->validate([
            'penduduk_id' => 'required'
        ]);
        $data_sk_belum_menikah = SKBelumMenikah::join('tb_surat_masyarakat', 'tb_surat_masyarakat.surat_masyarakat_id', '=', 'tb_sk_belum_menikah.surat_masyarakat_id')
                                            ->where('penduduk_id', Request()->penduduk_id)
                                            ->whereIn('status', ['Menunggu Respons', 'Dalam Verifikasi', 'Sedang Diproses'])
                                            ->get();
        return response()->json([
            'status' => 'OK',
            'message' => 'Data SK Belum Menikah Berhasil Didapatkan!',
            'data' => $data_sk_belum_menikah
        ]);
    }

    public function show_sk_belum_menikah_selesai() {
        Request()->validate([
            'penduduk_id' => 'required'
        ]);
        $data_sk_belum_menikah = SKBelumMenikah::join('tb_surat_masyarakat', 'tb_surat_masyarakat.surat_masyarakat_id', '=', 'tb_sk_belum_menikah.surat_masyarakat_id')
                                            ->where('penduduk_id', Request()->penduduk_id)
                                            ->where('status', 'Selesai')
                                            ->get();
        return response()->json([
            'status' => 'OK',
            'message' => 'Data SK Belum Menikah Berhasil Didapatkan!',
            'data' => $data_sk_belum_menikah
        ]);
    }

    public function cancel_sk_belum_menikah() {
        Request()->validate([
            'surat_masyarakat_id' => 'required',
            'id_sk_belum_menikah' => 'required'
        ]);
        $this->SKBelumMenikah->BatalkanSKBelumMenikah(Request()->id_sk_belum_menikah);
        $this->SuratMasyarakat->BatalkanSuratMasyarakat(Request()->surat_masyarakat_id);
        return response()->json([
            'status' => 'OK',
            'message' => 'Data SK Belum Menikah Berhasil Dihapus!'
        ]);
    }

    public function show_sk_kelakuan_baik_sedang_proses() {
        Request()->validate([
            'penduduk_id' => 'required'
        ]);
        $data_sk_kelakuan_baik = SKKelakuanBaik::join('tb_surat_masyarakat', 'tb_surat_masyarakat.surat_masyarakat_id', '=', 'tb_sk_kelakuan_baik.surat_masyarakat_id')
                                                ->where('penduduk_id', Request()->penduduk_id)
                                                ->whereIn('status', ['Menunggu Respons', 'Dalam Verifikasi', 'Sedang Diproses'])
                                                ->get();
        return response()->json([
            'status' => 'OK',
            'message' => 'Data SK Kelakuan Baik Berhasil Didapatkan!',
            'data' => $data_sk_kelakuan_baik
        ]);
    }

    public function show_sk_kelakuan_baik_selesai() {
        Request()->validate([
            'penduduk_id' => 'required'                                         
        ]);
        $data_sk_kelakuan_baik = SKKelakuanBaik::join('tb_surat_masyarakat', 'tb_surat_masyarakat.surat_masyarakat_id', '=', 'tb_sk_kelakuan_baik.surat_masyarakat_id')
                                                    ->where('penduduk_id', Request()->penduduk_id)
                                                    ->where('status', 'Selesai')
                                                    ->get();
        return response()->json([
            'status' => 'OK',
            'message' => 'Data SK Kelakuan Baik Berhasil Didapatkan!',
            'data' => $data_sk_kelakuan_baik
        ]);
    }

    public function cancel_sk_kelakuan_baik() {
        Request()->validate([
            'surat_masyarakat_id' => 'required',
            'id_sk_kelakuan_baik' => 'required'
        ]);
        $this->SKKelakuanBaik->BatalkanSKKelakuanBaik(Request()->id_sk_kelakuan_baik);
        $this->SuratMasyarakat->BatalkanSuratMasyarakat(Request()->surat_masyarakat_id);
        return response()->json([
            'status' => 'OK',
            'message' => 'Data SK Kelakuan Baik Berhasil Dihapus!'
        ]);
    }

    public function show_sk_tempat_usaha_sedang_proses() {
        Request()->validate([
            'pemohon_id' => 'required'
        ]);
        $data_sk_tempat_usaha = SKTempatUsaha::join('tb_surat_masyarakat', 'tb_surat_masyarakat.surat_masyarakat_id', '=', 'tb_sk_tempat_usaha.surat_masyarakat_id')
                                            ->join('tb_tempat_usaha', 'tb_tempat_usaha.id_tempat_usaha', '=', 'tb_sk_tempat_usaha.id_tempat_usaha')
                                            ->join('tb_desa', 'tb_desa.desa_id', '=', 'tb_surat_masyarakat.desa_id')
                                            ->join('tb_dusun', 'tb_dusun.dusun_id', '=', 'tb_tempat_usaha.dusun_id')
                                            ->where('pemohon_id', Request()->pemohon_id)
                                            ->whereIn('status', ['Menunggu Respons', 'Dalam Verifikasi', 'Sedang Diproses'])
                                            ->get();
        return response()->json([
            'status' => 'OK',
            'message' => 'Data SK Tempat Usaha Berhasil Didapatkan',
            'data' => $data_sk_tempat_usaha
        ]);
    }

    public function show_sk_tempat_usaha_selesai() {
        Request()->validate([
            'pemohon_id' => 'required'
        ]);
        $data_sk_tempat_usaha = SKTempatUsaha::join('tb_surat_masyarakat', 'tb_surat_masyarakat.surat_masyarakat_id', '=', 'tb_sk_tempat_usaha.surat_masyarakat_id')
                                            ->join('tb_tempat_usaha', 'tb_tempat_usaha.id_tempat_usaha', '=', 'tb_sk_tempat_usaha.id_tempat_usaha')
                                            ->join('tb_desa', 'tb_desa.desa_id', '=', 'tb_surat_masyarakat.desa_id')
                                            ->join('tb_dusun', 'tb_dusun.dusun_id', '=', 'tb_tempat_usaha.dusun_id')
                                            ->where('pemohon_id', Request()->pemohon_id)
                                            ->where('status', 'Selesai')
                                            ->get();
        return response()->json([
            'status' => 'OK',
            'message' => 'Data SK Tempat Usaha Berhasil Didapatkan',
            'data' => $data_sk_tempat_usaha
        ]);
    }

    public function show_sp_penghasilan_ortu_sedang_proses() {
        Request()->validate([
            'penduduk_id' => 'required'
        ]);
        $data_sp_penghasilan_ortu = SPPenghasilanOrtu::join('tb_surat_masyarakat', 'tb_surat_masyarakat.surat_masyarakat_id', '=', 'tb_sp_penghasilan_ortu.surat_masyarakat_id')
                                                    ->where('penduduk_id', Request()->penduduk_id)
                                                    ->whereIn('status', ['Menunggu Respons', 'Dalam Verifikasi', 'Sedang Diproses'])
                                                    ->get();
        return response()->json([
            'status' => 'OK',
            'message' => 'Data SP Penghasilan Orang Tua Berhasil Didapatkan!',
            'data' => $data_sp_penghasilan_ortu
        ]);
    }

    public function show_sp_penghasilan_ortu_selesai() {
        Request()->validate([
            'penduduk_id' => 'required'
        ]);
        $data_sp_penghasilan_ortu = SPPenghasilanOrtu::join('tb_surat_masyarakat', 'tb_surat_masyarakat.surat_masyarakat_id', '=', 'tb_sp_penghasilan_ortu.surat_masyarakat_id')
                                                    ->where('penduduk_id', Request()->penduduk_id)
                                                    ->where('status', 'Selesai')
                                                    ->get();
        return response()->json([
            'status' => 'OK',
            'message' => 'Data SP Penghasilan Orang Tua Berhasil Didapatkan!',
            'data' => $data_sp_penghasilan_ortu
        ]);
    }
}