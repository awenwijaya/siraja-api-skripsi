<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SPPenghasilanOrtu extends Model
{
    use HasFactory;

    protected $table = 'tb_sp_penghasilan_ortu';

    protected $fillable = [
        'id_sp_penghasilan',
        'orang_tua_id',
        'penduduk_id',
        'jumlah_penghasilan',
        'surat_masyarakat_id',
        'status',
        'keperluan'
    ];

    public function UpSPPenghasilanOrtu($data) {
        DB::table('tb_sp_penghasilan_ortu')->insert($data);
    }
}
