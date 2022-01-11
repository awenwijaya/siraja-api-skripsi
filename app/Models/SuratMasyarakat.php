<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SuratMasyarakat extends Model
{
    use HasFactory;

    protected $table = 'tb_surat_masyarakat';

    protected $fillable = [
        'surat_masyarakat_id',
        'master_surat_id',
        'tanggal_pengajuan',
        'tanggal_pengesahan',
        'desa_id'
    ];

    public function UpSuratMasyarakat($data) {
        DB::table('tb_surat_masyarakat')->insert($data);
    }
}
