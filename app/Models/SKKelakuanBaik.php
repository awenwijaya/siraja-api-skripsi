<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SKKelakuanBaik extends Model
{
    use HasFactory;

    protected $table = 'tb_sk_kelakuan_baik';

    protected $fillable = [
        'id_sk_kelakuan_baik',
        'penduduk_id',
        'surat_masyarakat_id',
        'status',
        'keperluan'
    ];

    public function UpSKKelakuanBaik($data) {
        DB::table('tb_sk_kelakuan_baik')->insert($data);
    }

    public function BatalkanSKKelakuanBaik($id) {
        DB::table('tb_sk_kelakuan_baik')
        ->where('id_sk_kelakuan_baik', $id)
        ->delete();
    }
}
