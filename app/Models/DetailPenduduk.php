<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DetailPenduduk extends Model
{
    use HasFactory;

    protected $table = 'tb_detail_penduduk';

    protected $fillable = [
        'detail_penduduk_id',
        'penduduk_id',
        'status_keluarga',
        'kartu_keluarga_id'
    ];
}
