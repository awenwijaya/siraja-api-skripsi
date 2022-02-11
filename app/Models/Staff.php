<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'tb_staff';

    protected $fillable = [
        'staff_id',
        'jabatan_id',
        'unit_id',
        'status',
        'penduduk_id',
        'masa_berakhir'
    ];

    public function UpDataStaff($data) {
        DB::table('tb_staff')->insert($data);
    }

    public function EditStaff($data, $id) {
        DB::table('tb_staff')
        ->where('staff_id', $id)
        ->update($data);
    }
}
