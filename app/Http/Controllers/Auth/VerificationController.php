<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpEmail;
use App\Models\User;
use App\Models\Verification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VerificationController extends Controller
{
    public function index() {
        return view('auth.verify');
    }

    public function send_otp(Request $request) {
        if($request->type == 'register') {
            $user = User::find($request->user()->id);
        } else {

        }

        if (!$user) return back()->with('error', 'User Not found');
        $otp = rand(100000, 999999);
        $verify = Verification::create([
            'user_id' => $user->id, 'unique_id' => uniqid(), 'otp' => md5($otp),
            'type' => $request->type, 'send_via' => 'email'
        ]);
        Mail::to($user->email)->queue(new OtpEmail($otp));

        if ($request->type == 'register') {
            return redirect('/verify/'.$verify->unique_id);
        }
    }
}
