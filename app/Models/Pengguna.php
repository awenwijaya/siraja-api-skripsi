<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pengguna extends Model
{
    public function Login($email, $password){
        return DB::table('tb_sso')
        ->select('id')
        ->where([
            ['email', '=', $email],
            ['password', '=', $password]
        ])->get();
    }

    public function Register($data){
        DB::table('tb_sso')->insert($data);
    }
}
