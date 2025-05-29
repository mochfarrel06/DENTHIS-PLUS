<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Queue;
use App\Models\Specialization;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahDokter = Doctor::count();
        $jumlahPasien = Patient::count();
        $jumlahAntrean = Queue::whereDate('tgl_periksa', Carbon::today())
            ->whereIn('status', ['booking', 'periksa']) // Menambahkan filter status booking dan periksa
            ->count();
        $jumlahSpesialisasi = Specialization::count();

        $antreanHariIni = Queue::whereDate('tgl_periksa', Carbon::today())
            ->orderBy('start_time', 'asc')
            ->where('status', '!=', 'selesai')
            ->where('status', '!=', 'batal')
            ->whereIn('status', ['booking', 'periksa']) // Menambahkan filter status booking dan periksa
            ->get();

        $antreanPerHari = DB::table('queues')
            ->join('doctors', 'queues.doctor_id', '=', 'doctors.id')
            ->join('specializations', 'doctors.specialization_id', '=', 'specializations.id')
            ->select('specializations.name as poli', DB::raw('count(*) as jumlah'))
            ->whereDate('tgl_periksa', Carbon::today())
            ->where('status', 'selesai')
            ->groupBy('poli')
            ->get();

        $antreanPerBulan = DB::table('queues')
            ->join('doctors', 'queues.doctor_id', '=', 'doctors.id')
            ->join('specializations', 'doctors.specialization_id', '=', 'specializations.id')
            ->select('specializations.name as poli', DB::raw('count(*) as jumlah'))
            ->whereMonth('tgl_periksa', Carbon::now()->month)
            ->whereYear('tgl_periksa', Carbon::now()->year)
            ->where('status', 'selesai')
            ->groupBy('poli')
            ->get();

        $antreanPerTahun = DB::table('queues')
            ->join('doctors', 'queues.doctor_id', '=', 'doctors.id')
            ->join('specializations', 'doctors.specialization_id', '=', 'specializations.id')
            ->select('specializations.name as poli', DB::raw('count(*) as jumlah'))
            ->whereYear('tgl_periksa', Carbon::now()->year)
            ->where('status', 'selesai')
            ->groupBy('poli')
            ->get();

        return view('admin.dashboard', compact('jumlahDokter', 'jumlahPasien', 'jumlahAntrean', 'antreanHariIni', 'jumlahSpesialisasi', 'antreanPerHari', 'antreanPerBulan', 'antreanPerTahun'));
    }
}
