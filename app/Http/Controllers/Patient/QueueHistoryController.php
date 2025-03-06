<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\QueueHistory;
use Illuminate\Http\Request;

class QueueHistoryController extends Controller
{
    public function index()
    {
        // $user = auth()->user();

        // if ($user->role == 'dokter' || $user->role == 'admin') {
        //     // Dokter dan Admin bisa melihat semua riwayat antrean
        //     $queues = QueueHistory::with(['doctor', 'patient'])->orderBy('tgl_periksa', 'desc')->get();
        // } else {
        //     // Pasien hanya bisa melihat riwayat antreannya sendiri
        //     $queues = QueueHistory::with(['doctor'])
        //         ->where('patient_id', $user->id)
        //         ->orderBy('tgl_periksa', 'desc')
        //         ->get();
        // }

        $queueHistories = QueueHistory::all();

        return view('patient.queue-history.index', compact('queueHistories'));
    }
}
