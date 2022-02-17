<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use DateTimeInterface;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'tb_staff';

    protected $dates = [
        'masa_berakhir',
        'tanggal_lahir',
        'masa_mulai'
      ];

    protected $fillable = [
        'staff_id',
        'jabatan_id',
        'unit_id',
        'status',
        'penduduk_id',
        'masa_mulai',
        'masa_berakhir',
        'file_sk',
        'desa_id'
    ];

    public function UpDataStaff($data) {
        DB::table('tb_staff')->insert($data);
    }

    public function EditStaff($data, $id) {
        DB::table('tb_staff')
        ->where('staff_id', $id)
        ->update($data);
    }

    protected function serializeDate(DateTimeInterface $date) {
      return $date->format('d-M-Y');
    }
}
