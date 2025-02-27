<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use App\Models\Queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicalRecordController extends Controller
{
    public function index()
    {
        // // Jika user adalah dokter, tampilkan semua rekam medis yang dibuatnya
        // if (auth()->user()->role = 'dokter') {
        //     $medicalRecords = MedicalRecord::where('doctor_id', auth()->id())->get();
        // }
        // // Jika user adalah pasien, tampilkan hanya rekam medisnya sendiri
        // else {
        //     $medicalRecords = MedicalRecord::where('user_id', auth()->id())->get();
        // }

        $medicalRecords = MedicalRecord::all();

        return view('doctor.medical-record.index', compact('medicalRecords'));
    }

    public function create()
    {
        $queues = Queue::where('status', 'periksa')->get();
        return view('doctor.medical-record.create', compact('queues'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'queue_id' => 'required|exists:queues,id',
            'diagnosis' => 'required|string',
            'resep' => 'required|string',
            'catatan_medis' => 'nullable|string',
        ]);

        $queue = Queue::findOrFail($request->queue_id);
        $userId = Auth::id();

        MedicalRecord::create([
            'user_id' => $queue->user_id,
            // 'doctor_id' => $queue->user_id,
            'queue_id' => $queue->id,
            'tgl_periksa' => now(),
            'diagnosis' => $request->diagnosis,
            'resep' => $request->resep,
            'catatan_medis' => $request->catatan_medis,
        ]);

        $queue->update(['status' => 'selesai']);

        return redirect()->route('doctor.medical-record.index')->with('success', 'Rekam medis berhasil disimpan.');
    }

    // public function show($queueId)
    // {
    //     $medicalRecord = MedicalRecord::where('queue_id', $queueId)->firstOrFail();
    //     return view('doctor.medical_record.show', compact('medicalRecord'));
    // }
}
