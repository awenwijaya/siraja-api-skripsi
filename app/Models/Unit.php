<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Unit extends Model
{
    use HasFactory;

    protected $table = 'tb_unit';

    protected $fillable = [
        'unit_id',
        'nama_unit'
    ];
}
