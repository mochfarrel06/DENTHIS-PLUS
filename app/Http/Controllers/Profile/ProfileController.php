<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserManagement\ProfileUpdate;
use App\Http\Requests\UserManagement\UserManagementUpdateRequest;
use App\Models\Specialization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $role = $user->role;
        $specializations = Specialization::all();

        return view('profile.index', compact('user', 'specializations', 'role'));
    }

    public function update(Request $request)
    {
        try {
            // dd($request->all());
            $userId = Auth::id();
            $user = User::findOrFail($userId);

            $users = $request->except('password');

            // Handle password update
            if ($request->filled('password')) {
                $users['password'] = bcrypt($request->password);
            }

            $user->fill($users);

            if ($user->isDirty()) {
                $user->save();

                session()->flash('success', 'Berhasil melakukan perubahan data manajemen pengguna');
                return response()->json(['success' => true], 200);
            } else {
                session()->flash('info', 'Tidak melakukan perubahan data manajemen pengguna');
                return response()->json(['info' => true], 200);
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Terdapat kesalahan pada proses updata manajemen pengguna: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
