<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();

        if ($request->user()->role === 'admin') {
            session()->flash('success', 'Berhasil masuk aplikasi');
            return redirect()->intended(RouteServiceProvider::ADMIN);
        } else if ($request->user()->role === 'dokter') {
            session()->flash('success', 'Berhasil masuk aplikasi');
            return redirect()->intended(RouteServiceProvider::DOCTOR);
        } else if ($request->user()->role === 'pasien') {
            session()->flash('success', 'Berhasil masuk aplikasi');
            return redirect()->intended(RouteServiceProvider::PATIENT);
        }
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        session()->flash('success', 'Berhasil keluar aplikasi');
        return redirect('/login');
    }
}
