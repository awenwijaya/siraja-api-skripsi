<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Desa;
use App\Models\Penduduk;
use App\Models\Staff;

class AdminController extends Controller
{
    public function __construct() {
        $this->Desa = new Desa;
        $this->Penduduk = new Penduduk;
        $this->Staff = new Staff;
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
}
