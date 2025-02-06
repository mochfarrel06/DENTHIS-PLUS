<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\DoctorStoreRequest;
use App\Http\Requests\Doctor\DoctorUpdateRequest;
use App\Models\Doctor;
use App\Models\User;
use App\Traits\ProfileUploadTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{
    use ProfileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctor::all();

        return view('admin.doctor.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.doctor.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DoctorStoreRequest $request)
    {
        try {
            $imagePath = $this->uploadImage($request, 'foto_dokter');

            $doctor = new Doctor([
                'kode_dokter' => Doctor::generateKodeDokterGigi(),
                'nama_depan' => $request->nama_depan,
                'nama_belakang' => $request->nama_belakang,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'no_hp' => $request->no_hp,
                'tgl_lahir' => $request->tgl_lahir,
                'pengalaman' => $request->pengalaman,
                'jenis_kelamin' => $request->jenis_kelamin,
                'golongan_darah' => $request->golongan_darah,
                'foto_dokter' => isset($imagePath) ? $imagePath : 'foto_dokter',
                'alamat' => $request->alamat,
                'negara' => $request->negara,
                'provinsi' => $request->provinsi,
                'kota' => $request->kota,
                'kodepos' => $request->kodepos,
            ]);

            $doctor->save();

            User::create([
                'name' => $request->nama_depan . ' ' . $request->nama_belakang,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'dokter'
            ]);

            session()->flash('success', 'Berhasil menambahkan data dokter');
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            session()->flash('error', 'Terdapat kesalahan pada proses data dokter: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $doctor = Doctor::findOrFail($id);

        return view('admin.doctor.show', compact('doctor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $doctor = Doctor::findOrFail($id);

        return view('admin.doctor.edit', compact('doctor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DoctorUpdateRequest $request, string $id)
    {
        try {
            $doctor = Doctor::findOrFail($id);
            $doctors = $request->except(['foto_dokter', 'password']);

            if ($request->hasFile('foto_dokter')) {
                if ($doctor->foto_dokter && file_exists(public_path($doctor->foto_dokter))) {
                    unlink(public_path($doctor->foto_dokter));
                }

                $imagePath = $this->uploadImage($request, 'foto_dokter');
                $doctors['foto_dokter'] = $imagePath;
            }

            // Handle password update
            if ($request->filled('password')) {
                $doctors['password'] = bcrypt($request->password);
            }

            $doctor->fill($doctors);

            if ($doctor->isDirty()) {
                $doctor->save();

                session()->flash('success', 'Berhasil melakukan perubahan pada data dokter');
                return response()->json(['success' => true], 200);
            } else {
                session()->flash('info', 'Tidak melakukan perubahan pada data dokter');
                return response()->json(['info' => true], 200);
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Terdapat kesalahan pada proses update data dokter: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $doctor = Doctor::findOrFail($id);

            if ($doctor->foto_dokter) {
                $photoPath = public_path($doctor->foto_dokter);
                if (file_exists($photoPath)) {
                    unlink($photoPath);
                }
            }

            // Hapus data user terkait
            $user = User::where('email', $doctor->email)->first();
            if ($user) {
                $user->delete();
            }

            $doctor->delete();

            return response(['status' => 'success', 'message' => 'Berhasil menghapus data dokter']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
