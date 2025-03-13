<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\QueueHistory;
use Illuminate\Http\Request;

class QueueHistoryController extends Controller
{
    public function index()
    {
        // $queueHistories = QueueHistory::all();

        // return view('patient.queue-history.index', compact('queueHistories'));

        $user = auth()->user();
        $role = $user->role; // Pastikan ada kolom 'role' di tabel users

        // Jika user adalah admin atau dokter, tampilkan semua rekam medis
        if ($role === 'admin' || $role === 'dokter') {
            $queueHistories = QueueHistory::all();
        } else {
            // Jika user adalah pasien, hanya tampilkan rekam medis miliknya
            $queueHistories = QueueHistory::where('user_id', $user->id)->get();
        }

        return view('patient.queue-history.index', compact('queueHistories'));
    }
}
