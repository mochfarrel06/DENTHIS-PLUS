<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Patient\PatientStoreRequest;
use App\Models\Patient;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

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

        $user = $request->user();

        if ($user->role === 'admin') {
            session()->flash('success', 'Berhasil masuk aplikasi');
            return redirect()->intended(RouteServiceProvider::ADMIN);
        } elseif ($user->role === 'dokter') {
            session()->flash('success', 'Berhasil masuk aplikasi');
            return redirect()->intended(RouteServiceProvider::DOCTOR);
        } elseif ($user->role === 'pasien') {
            if ($user->status === 'active') {
                session()->flash('success', 'Berhasil masuk aplikasi');
                return redirect()->intended(RouteServiceProvider::PATIENT);
            } elseif ($user->status === 'verify') {
                auth()->logout();
                return redirect()->route('login')->withErrors([
                    'email' => 'Akun Anda belum diverifikasi. Silakan verifikasi terlebih dahulu.',
                ]);
            } elseif ($user->status === 'banned') {
                auth()->logout();
                return redirect()->route('login')->withErrors([
                    'email' => 'Akun Anda telah diblokir. Silakan hubungi administrator.',
                ]);
            }
        }

        // Default fallback jika role tidak dikenali
        auth()->logout();
        return redirect()->route('login')->withErrors([
            'email' => 'Role tidak dikenali atau akses ditolak.',
        ]);
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        session()->flash('success', 'Berhasil keluar aplikasi');
        return redirect('/login');
    }

    public function indexRegister()
    {
        return view('auth.register');
    }

    public function storeRegister(PatientStoreRequest $request)
    {
        try {
            // $defaultFotoPath = public_path('uploads/foto_dokter/default2.jpg');
            // $newFotoName = Str::random(20) . '.jpg'; // nama file unik
            // $destinationPath = public_path('uploads/foto_pasien/' . $newFotoName);

            // File::copy($defaultFotoPath, $destinationPath);

            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $newFotoName = Str::random(20) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/foto_pasien'), $newFotoName);
            } else {
                // jika tidak upload, pakai default
                $defaultFotoPath = public_path('uploads/foto_dokter/default2.jpg');
                $newFotoName = Str::random(20) . '.jpg';
                File::copy($defaultFotoPath, public_path('uploads/foto_pasien/' . $newFotoName));
            }

            // Buat user
            $user = User::create([
                'nama_depan'    => $request->nama_depan,
                'nama_belakang' => $request->nama_belakang,
                'email'         => $request->email,
                'password'      => Hash::make($request->password),
                'role'          => 'pasien',
                'status'        => 'verify', // status awal
                'no_hp'         => $request->no_hp,
                'tgl_lahir'     => $request->tgl_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat'        => $request->alamat,
                'negara'        => $request->negara,
                'provinsi'      => $request->provinsi,
                'kota'          => $request->kota,
                'kodepos'       => $request->kodepos,
                'foto'          => '/uploads/foto_pasien/' . $newFotoName,
                'alergi'        => $request->alergi
            ]);

            // Buat patient
            $patient = new Patient([
                'user_id'       => $user->id,
                'kode_pasien'   => Patient::generateKodePasien(),
                'nama_depan'    => $request->nama_depan,
                'nama_belakang' => $request->nama_belakang,
                'email'         => $request->email,
                'password'      => Hash::make($request->password),
                'no_hp'         => $request->no_hp,
                'tgl_lahir'     => $request->tgl_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat'        => $request->alamat,
                'negara'        => $request->negara,
                'provinsi'      => $request->provinsi,
                'kota'          => $request->kota,
                'kodepos'       => $request->kodepos,
                'foto'          => '/uploads/foto_pasien/' . $newFotoName,
                'alergi'        => $request->alergi
            ]);
            $patient->save();

            // Login otomatis
            Auth::login($user);

            // Redirect ke dashboard pasien
            session()->flash('success', 'Pendaftaran berhasil. Selamat datang!');
            return redirect()->route('patient.dashboard');
        } catch (\Exception $e) {
            session()->flash('error', 'Terdapat kesalahan pada proses pembuatan akun: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function indexForgot()
    {
        return view('auth.forgotPassword');
    }
}
