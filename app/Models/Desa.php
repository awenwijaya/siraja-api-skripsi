<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Desa extends Model
{
    use HasFactory;

    protected $table = 'tb_desa';

    protected $fillable = [
        'desa_id',
        'nama_desa',
        'kode_pos',
        'alamat_desa',
        'telpon_desa',
        'logo_desa',
        'jenis_desa',
        'kecamatan_id'
    ];

    public function UpSejarahDesa($id, $data) {
        DB::table('tb_desa')
        ->where('desa_id', $id)
        ->update($data);
    }

}
