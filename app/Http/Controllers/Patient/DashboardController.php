<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Queue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $jumlahAntrean = Queue::whereDate('tgl_periksa', Carbon::today())
            ->where('user_id', $userId)
            ->whereIn('status', ['booking', 'periksa']) // Menambahkan filter status booking dan periksa
            ->count();

        $antreanHariIni = Queue::whereDate('tgl_periksa', Carbon::today())
            ->where('user_id', $userId)
            ->orderBy('start_time', 'asc')
            ->where('status', '!=', 'selesai')
            ->where('status', '!=', 'batal')
            ->whereIn('status', ['booking', 'periksa']) // Menambahkan filter status booking dan periksa
            ->get();

        return view('patient.dashboard', compact('jumlahAntrean', 'antreanHariIni'));
    }
}
