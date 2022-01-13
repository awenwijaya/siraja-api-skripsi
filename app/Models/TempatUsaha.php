<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TempatUsaha extends Model
{
    use HasFactory;

    protected $table = 'tb_tempat_usaha';

    protected $fillable = [
        'id_tempat_usaha',
        'nama_usaha',
        'jenis_usaha',
        'alamat_usaha',
        'dusun_id',
        'penduduk_id',
        'foto'
    ];

    public function UpDataTempatUsaha($data) {
        DB::table('tb_tempat_usaha')->insert($data);
    }
}
