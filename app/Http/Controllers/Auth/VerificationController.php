<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function index() {
        return view('auth.verify');
    }

    public function send_otp(Request $request) {
        if($request->type == 'register') {
            $user = User::find($request->user()->id);
            dd($user);
        }

        dd($request->all());
    }
}
