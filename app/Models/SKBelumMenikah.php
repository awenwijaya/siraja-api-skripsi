<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SKBelumMenikah extends Model
{
    use HasFactory;

    protected $table = 'tb_sk_belum_menikah';

    protected $fillable = [
        'id_sk_belum_menikah',
        'penduduk_id',
        'surat_masyarakat_id',
        'status',
        'keperluan'
    ];

    public function UpSKBelumMenikah($data) {
        DB::table('tb_sk_belum_menikah')->insert($data);
    }
}
