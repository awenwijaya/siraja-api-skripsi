<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Jabatan extends Model
{
    use HasFactory;

    protected $table = 'tb_jabatan';

    protected $fillable = [
        'jabatan_id',
        'nama_jabatan'
    ];
}
