<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Kecamatan extends Model
{
    protected $table = 'tb_kecamatan';

    protected $fillable = [
        'kecamatan_id',
        'nama_kecamatan',
        'kabupaten_id'
    ];
}
