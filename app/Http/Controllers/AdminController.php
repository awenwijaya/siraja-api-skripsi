<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Desa;

class AdminController extends Controller
{
    public function __construct() {
        $this->Desa = new Desa;
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
}
