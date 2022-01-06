<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Dusun extends Model
{
    use HasFactory;

    protected $table = 'tb_dusun';

    protected $fillable = [
        'dusun_id',
        'nama_dusun',
        'desa_id'
    ];
}
