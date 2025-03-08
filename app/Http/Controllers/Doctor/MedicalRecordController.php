<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\MedicalRecordStoreRequest;
use App\Models\MedicalRecord;
use App\Models\Queue;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicalRecordController extends Controller
{
    public function index()
    {
        $medicalRecords = MedicalRecord::all();

        return view('doctor.medical-record.index', compact('medicalRecords'));
    }

    public function create()
    {
        $queues = Queue::where('status', 'periksa')->get();
        return view('doctor.medical-record.create', compact('queues'));
    }

    public function store(MedicalRecordStoreRequest $request)
    {
        try {
            $queue = Queue::findOrFail($request->queue_id);

            MedicalRecord::create([
                'user_id' => $queue->user_id,
                'queue_id' => $queue->id,
                'tgl_periksa' => now(),
                'diagnosis' => $request->diagnosis,
                'resep' => $request->resep,
                'catatan_medis' => $request->catatan_medis,
            ]);

            $queue->update(['status' => 'selesai']);

            session()->flash('success', 'Berhasil menambahkan data rekam medis');
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            session()->flash('error', 'Terdapat kesalahan pada proses data dokter: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function generatePDF($id)
    {
        $medicalRecord = MedicalRecord::with(['patient', 'queue'])->findOrFail($id);

        $pdf = Pdf::loadView('doctor.medical-record.pdf', compact('medicalRecord'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('rekam_medis_' . $medicalRecord->patient->name . '.pdf');
    }

    public function show(string $id)
    {
        $medicalRecord = MedicalRecord::findOrFail($id);
        return view('doctor.medical-record.show', compact('medicalRecord'));
    }
}
