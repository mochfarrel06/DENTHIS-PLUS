<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahDokter = Doctor::count();
        $jumlahPasien = Patient::count();

        return view('admin.dashboard', compact('jumlahDokter', 'jumlahPasien'));
    }
}
