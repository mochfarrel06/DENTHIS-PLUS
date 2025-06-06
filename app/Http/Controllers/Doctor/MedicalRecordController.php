<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\MedicalRecordStoreRequest;
use App\Models\MedicalRecord;
use App\Models\Queue;
use App\Models\QueueHistory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicalRecordController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $role = $user->role;

        if ($role === 'admin' || $role === 'dokter') {
            $medicalRecords = MedicalRecord::with('user')->get();
        } else {
            // $medicalRecords = MedicalRecord::where('user_id', $user->id)->get();
            $medicalRecords = MedicalRecord::with('user')->where('user_id', $user->id)->get();
        }

        return view('doctor.medical-record.index', compact('medicalRecords'));
    }

    public function create()
    {
        $user = auth()->user();
        $queues = Queue::where('status', 'periksa')
            ->where('doctor_id', $user->doctor->id)
            ->get();
        return view('doctor.medical-record.create', compact('queues'));
    }

    public function store(MedicalRecordStoreRequest $request)
    {
        try {
            $queue = Queue::findOrFail($request->queue_id);

            $fileNames = [];

            if ($request->hasFile('dokumen')) {
                foreach ($request->file('dokumen') as $file) {
                    $fileName = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
                    $file->move(public_path('dokumen_rekam_medis'), $fileName);
                    $fileNames[] = $fileName;
                }
            }

            $medicalRecord = MedicalRecord::create([
                'user_id' => $queue->user_id,
                'queue_id' => $queue->id,
                'tgl_periksa' => now(),
                'diagnosis' => $request->diagnosis,
                'resep' => $request->resep,
                'catatan_medis' => $request->catatan_medis,
                'dokumen' => !empty($fileNames) ? json_encode($fileNames) : null,
            ]);

            $queue->update([
                'status' => 'selesai',
                'medical_id' => $medicalRecord->id,
            ]);

            session()->flash('success', 'Berhasil menambahkan data rekam medis');
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            session()->flash('error', 'Terdapat kesalahan pada proses data dokter: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function generatePDF($id)
    {
        $medicalRecord = MedicalRecord::with(['patient', 'queue', 'user'])->findOrFail($id);

        $pdf = Pdf::loadView('doctor.medical-record.pdf', compact('medicalRecord'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('rekam_medis.pdf');
    }

    public function show(string $id)
    {
        $medicalRecord = MedicalRecord::with('patient', 'user')->findOrFail($id);
        return view('doctor.medical-record.show', compact('medicalRecord'));
    }
}
