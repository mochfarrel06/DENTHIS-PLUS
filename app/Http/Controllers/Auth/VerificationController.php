<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpEmail;
use App\Models\User;
use App\Models\Verification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class VerificationController extends Controller
{
    public function index()
    {
        return view('auth.verify');
    }

    public function show($unique_id)
    {
        $verify = Verification::whereUserId(Auth::user()->id)->whereUniqueId($unique_id)
            ->whereStatus('active')->count();

        return view('emails.show', compact('unique_id'));
    }

    public function update(Request $request, $unique_id)
    {
        $verify = Verification::whereUserId(Auth::user()->id)->whereUniqueId($unique_id)
            ->whereStatus('active')->first();

        if (!$verify) {
            return redirect()->route('verify.show', $unique_id)
                ->with('error', 'Data verifikasi tidak ditemukan atau sudah tidak aktif.');
        }

        $verify->increment('resend');

        if ($verify->resend >= 3) {
            $verify->update(['status' => 'invalid']);
            return redirect()->route('verify')->with('error', 'Kode OTP salah lebih dari 3 kali. Verifikasi diblokir.');
        }

        if (md5($request->otp) != $verify->otp) {
            return redirect()->route('verify.show', $unique_id)
                ->with('error', 'Kode OTP salah. Silakan coba lagi.');
        }

        $verify->update(['status' => 'valid']);
        User::find($verify->user_id)->update(['status' => 'active']);

        return redirect('/patient/dashboard');
    }

    public function send_otp(Request $request)
    {
        if ($request->type == 'register') {
            $user = User::find($request->user()->id);
        } else {
        }

        if (!$user) return back()->with('error', 'User Not found');
        $otp = rand(100000, 999999);
        $verify = Verification::create([
            'user_id' => $user->id,
            'unique_id' => uniqid(),
            'otp' => md5($otp),
            'type' => $request->type,
            'send_via' => 'email'
        ]);
        Mail::to($user->email)->queue(new OtpEmail($otp));

        if ($request->type == 'register') {
            return redirect('/verify/' . $verify->unique_id);
        }
    }

    public function forgotPasswordForm()
    {
        return view('auth.auth-password');
    }

    public function sendForgotPasswordOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email tidak ditemukan');
        }

        $otp = rand(100000, 999999);
        $verification = Verification::create([
            'user_id' => $user->id,
            'unique_id' => uniqid(),
            'otp' => md5($otp),
            'type' => 'reset_password',
            'send_via' => 'email',
        ]);

        Mail::to($user->email)->queue(new OtpEmail($otp));

        return redirect()->route('reset.password', $verification->unique_id)
            ->with('success', 'OTP telah dikirim ke email Anda.');
    }

    public function resetPasswordForm($unique_id)
    {
        return view('auth.reset-password', compact('unique_id'));
    }

    public function resetPassword(Request $request, $unique_id)
    {
        $request->validate([
            'otp' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        $verification = Verification::where('unique_id', $unique_id)
            ->where('type', 'reset_password')
            ->where('status', 'active')
            ->first();

        if (!$verification || md5($request->otp) !== $verification->otp) {
            return back()->with('error', 'OTP salah atau tidak valid.');
        }

        $user = User::find($verification->user_id);
        $user->update([
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Password berhasil direset, silakan login kembali.');
    }
}
