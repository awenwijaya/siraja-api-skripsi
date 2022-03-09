<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pengguna extends Model
{

    use HasFactory;

    protected $table = 'tb_sso';

    protected $fillable = [
        'user_id',
        'username',
        'email',
        'password',
        'nomor_telepon',
        'role',
        'penduduk_id',
        'desa_id',
        'email_verified_at',
        'remember_token',
        'token_activation',
        'created_at',
        'updated_at'
    ];

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

    public function KonfirmasiEmail($data, $email) {
        DB::table('tb_sso')
        ->where('email', $email)
        ->update($data);
    }

    public function showDataByEmail($email){
        DB::table('tb_sso')
        ->where('email', $email)
        ->first();
    }

    public function EditProfile($data, $id) {
        DB::table('tb_sso')
        ->where('user_id', $id)
        ->update($data);
    }

    public function ResetPassword($data, $email) {
        DB::table('tb_sso')
        ->where('email', $email)
        ->update($data);
    }
}