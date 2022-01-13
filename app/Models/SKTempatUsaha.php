<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SKTempatUsaha extends Model
{
    use HasFactory;

    protected $table = 'tb_sk_tempat_usaha';

    protected $fillable = [
        'id_sk_tempat_usaha',
        'pemohon_id',
        'id_tempat_usaha',
        'surat_masyarakat_id',
        'status'
    ];

    public function UpSKTempatUsaha($data) {
        DB::table('tb_sk_tempat_usaha')->insert($data);
    }
}
