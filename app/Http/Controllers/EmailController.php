<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;

class EmailController extends Controller
{
    public function index() {
        Mail::to('hariwijayaawen@gmail.com')->send(new SendEmail);
        return response()->json([
            'status' => 'OK',
            'message' => 'Konfirmasi Email berhasil Dikirimkan!'
        ], 200);
    }
}
