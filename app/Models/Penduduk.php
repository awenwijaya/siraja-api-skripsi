<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Penduduk extends Model
{
    public function CekPenduduk($nik){
        return DB::table('tb_penduduk')
        ->where('nik', $nik)
        ->first();
    }
}
