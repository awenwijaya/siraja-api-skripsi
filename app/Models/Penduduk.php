<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use DateTimeInterface;

class Penduduk extends Model
{

    use HasFactory;

    protected $table = 'tb_penduduk';

    protected $dates = [
        'tanggal_lahir'
      ];

    protected $fillable = [
        'penduduk_id',
        'nik',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'agama',
        'status_perkawinan',
        'pekerjaan_id',
        'kewarganegaraan',
        'golongan_darah',
        'jenis_kelamin',
        'pendidikan_terakhir',
        'status_penduduk',
        'id_desa'
    ];

    public function CekPenduduk($nik){
        return DB::table('tb_penduduk')
        ->where('nik', $nik)
        ->first();
    }

    public function EditPenduduk($data, $id) {
        DB::table('tb_penduduk')
        ->where('penduduk_id', $id)
        ->update($data);
    }

    protected function serializeDate(DateTimeInterface $date)
  {
    return $date->format('d-M-Y');
  }
}
