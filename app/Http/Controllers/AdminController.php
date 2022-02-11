<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Desa;
use App\Models\Penduduk;
use App\Models\Staff;
use App\Models\Unit;
use App\Models\Jabatan;

class AdminController extends Controller
{
    public function __construct() {
        $this->Desa = new Desa;
        $this->Penduduk = new Penduduk;
        $this->Staff = new Staff;
        $this->Jabatan = new Jabatan;
        $this->Unit = new Unit;
    }

    public function up_sejarah_desa() {
        Request()->validate([
            'desa_id' => 'required',
            'sejarah_desa' => 'required'
        ]);
        $data = [
            'sejarah_desa' => Request()->sejarah_desa
        ];
        $this->Desa->UpSejarahDesa(Request()->desa_id, $data);
        return response()->json([
            'status' => 'Success',
            'message' => 'Data Sejarah Desa Berhasil Diperbaharui!'
        ], 200);
    }

    public function show_staff_desa_by_id_aktif($id) {
        $data = Staff::join('tb_penduduk', 'tb_penduduk.penduduk_id', '=', 'tb_staff.penduduk_id')
                    ->join('tb_unit', 'tb_unit.unit_id', '=', 'tb_staff.unit_id')
                    ->join('tb_jabatan', 'tb_jabatan.jabatan_id', '=', 'tb_staff.jabatan_id')
                    ->join('tb_desa', 'tb_desa.desa_id', '=', 'tb_penduduk.desa_id')
                    ->where('tb_penduduk.desa_id', $id)
                    ->where('tb_staff.status', 'Aktif')
                    ->get();
        return response()->json([
            'status' => 'Success',
            'message' => 'Data Staff Desa Berhasil Didapatkan!',
            'data' => $data
        ], 200);
    }

    public function show_staff_desa_by_id_tidak_aktif($id) {
        $data = Staff::join('tb_penduduk', 'tb_penduduk.penduduk_id', '=', 'tb_staff.penduduk_id')
                    ->join('tb_unit', 'tb_unit.unit_id', '=', 'tb_staff.unit_id')
                    ->join('tb_jabatan', 'tb_jabatan.jabatan_id', '=', 'tb_staff.jabatan_id')
                    ->join('tb_desa', 'tb_desa.desa_id', '=', 'tb_penduduk.desa_id')
                    ->where('tb_penduduk.desa_id', $id)
                    ->where('tb_staff.status', 'Tidak Aktif')
                    ->get();
        return response()->json([
            'status' => 'Success',
            'message' => 'Data Staff Desa Berhasil Didapatkan!',
            'data' => $data
        ], 200);
    }

    public function cek_nik_staff($id) {
        $hasil_cek = Penduduk::select()->where('penduduk_id', $id)->first();
        $data_penduduk = json_decode($hasil_cek);
        $penduduk_id = $data_penduduk->penduduk_id;
        $cek_staff = Staff::select()->where('penduduk_id', $penduduk_id)->first();
        if($hasil_cek == null) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Data penduduk tidak ditemukan'
            ], 500);
        }else{
            if($cek_staff == null) {
                return response()->json($hasil_cek, 200);
            }else{
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Staff sudah terdaftar!'
                ], 501);
            }
        }
    }

    public function list_jabatan() {
        $data = Jabatan::select()->get();
        return response()->json($data, 200);
    }

    public function list_unit() {
        $data = Unit::select()->get();
        return response()->json($data, 200);
    }

    public function simpan_staff() {
        Request()->validate([
            'penduduk_id' => 'required',
            'nama_jabatan' => 'required',
            'nama_unit' => 'required'
        ]);
        $jabatan = Jabatan::select('jabatan_id')->where('nama_jabatan', Request()->nama_jabatan)->first();
        $data_jabatan = json_decode($jabatan);
        $unit = Unit::select('unit_id')->where('nama_unit', Request()->nama_unit)->first();
        $data_unit = json_decode($unit);
        $data = [
           'jabatan_id' => $data_jabatan->jabatan_id,
           'unit_id' => $data_unit->unit_id,
           'status' => 'Aktif',
           'penduduk_id' => Request()->penduduk_id 
        ];
        $this->Staff->UpDataStaff($data);
        return response()->json([
            'status' => "OK",
            'message' => 'Data Pegawai berhasil Didaftarkan!'
        ], 200);
    }

    public function update_staff() {
        Request()->validate([
            'nama_jabatan' => 'required',
            'nama_unit' => 'required',
            'staff_id' => 'required'
        ]);
        $jabatan = Jabatan::select('jabatan_id')->where('nama_jabatan', Request()->nama_jabatan)->first();
        $data_jabatan = json_decode($jabatan);
        $unit = Unit::select('unit_id')->where('nama_unit', Request()->nama_unit)->first();
        $data_unit = json_decode($unit);
        $data = [
            'jabatan_id' => $data_jabatan->jabatan_id,
            'unit_id' => $data_unit->unit_id
        ];
        $this->Staff->EditStaff($data, Request()->staff_id);
        return response()->json([
            'status' => 'OK',
            'message' => 'Data Staff berhasil Diperbaharui'
        ], 200);
    }
}