<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function indexDokter()
    {
        return view('user.dokter');
    }

    public function indexTentangKami()
    {
        return view('user.tentang-kami');
    }
}
