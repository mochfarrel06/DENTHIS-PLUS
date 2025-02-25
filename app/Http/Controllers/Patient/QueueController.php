<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Patient;
use App\Models\Queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QueueController extends Controller
{
    public function index()
    {
        // $queues = Queue::with('doctor')->get();
        // $queues = Queue::where('user_id', auth()->id())->get();
        $queues = Queue::with('doctor')->get();
        $userQueue = Queue::where('user_id', auth()->id())->where('status', 'called')->first();
        return view('patient.queue.index', compact('queues', 'userQueue'));
    }

    public function create(Request $request)
    {
        $doctors = Doctor::all();
        $patients = Patient::all();

        if ($request->has('doctor_id') && $request->has('date')) {
            $doctorId = $request->input('doctor_id');
            $date = $request->input('date');

            $dayOfWeek = \Carbon\Carbon::parse($date)->format('l');
            $doctorSchedules = DoctorSchedule::where('doctor_id', $doctorId)
                ->where('hari', $dayOfWeek)
                ->get();

            $slots = [];
            foreach ($doctorSchedules as $schedule) {
                $start = \Carbon\Carbon::parse($schedule->jam_mulai);
                $end = \Carbon\Carbon::parse($schedule->jam_selesai);

                $waktuPeriksa = $schedule->waktu_periksa ?? 30; // Default 30 menit
                $waktuJeda = $schedule->waktu_jeda ?? 10; // Default 10 menit

                while ($start->copy()->addMinutes($waktuPeriksa)->lte($end)) {
                    $slotStart = $start->format('H:i');
                    $slotEnd = $start->copy()->addMinutes($waktuPeriksa)->format('H:i');

                    // Cek apakah slot sudah dipesan
                    $isBooked = Queue::where('doctor_id', $doctorId)
                        ->where('tgl_periksa', $date)
                        ->where('start_time', $slotStart)
                        ->exists();

                    $slots[] = [
                        'start' => $slotStart,
                        'end' => $slotEnd,
                        'is_booked' => $isBooked
                    ];

                    $start->addMinutes($waktuPeriksa + $waktuJeda);
                }
            }

            return response()->json($slots);
        }

        return view('patient.queue.create', compact('doctors', 'patients'));
    }

    public function store(Request $request)
    {
        $userId = Auth::id();

        // Ambil email dari user yang sedang login
        $userEmail = Auth::user()->email;

        // Cari pasien berdasarkan email user yang sedang login
        $patient = Patient::where('email', $userEmail)->first();

        // dd($patient);

        if (!$patient) {
            return redirect()->back()->withErrors(['error' => 'Data pasien tidak ditemukan untuk pengguna ini.']);
        }

        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'tgl_periksa' => 'required|date',
            'start_time' => 'required',
            'keterangan' => 'required',
            'end_time' => 'required',
        ]);

        // Cek apakah slot waktu sudah dipesan
        $existingQueue = Queue::where('doctor_id', $request->doctor_id)
            ->where('tgl_periksa', $request->tgl_periksa)
            ->where('start_time', $request->start_time)
            ->exists();

        if ($existingQueue) {
            return redirect()->back()->withErrors(['error' => 'Slot waktu ini sudah dipesan.']);
        }

        // Menentukan nomor urut antrean
        // $lastQueue = Queue::where('doctor_id', $request->doctor_id)
        //     ->where('tgl_periksa', $request->tgl_periksa)
        //     ->orderBy('urutan', 'desc')
        //     ->first();

        // Generate nomor urutan dengan format ANTREAN0001, ANTREAN0002, dst.
        // $lastNumber = $lastQueue ? (int) substr($lastQueue->urutan, 7) : 0;
        // $newUrutan = 'ANTREAN' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        // Simpan data antrean
        Queue::create([
            'user_id' => $userId,
            'doctor_id' => $request->doctor_id,
            'patient_id' => $patient->id,
            'tgl_periksa' => $request->tgl_periksa,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'keterangan' => $request->keterangan,
            // 'urutan' => $newUrutan,
            'status' => 'booking',
            'is_booked' => true
        ]);

        return redirect()->route('data-patient.queue.index')->with('success', 'Antrean berhasil ditambahkan.');
    }

    public function destroy(string $id)
    {
        try {
            $queue = Queue::findOrFail($id);
            $queue->delete();

            return response(['status' => 'success', 'message' => 'Berhasil menghapus data pasien']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function callPatient($id)
    {
        $queue = Queue::findOrFail($id);
        // Kirim event ke WebSocket atau gunakan sesi untuk menampilkan alert ke pasien
        $queue->status = 'called';
        $queue->save();
        return response()->json(['status' => 'success', 'message' => 'Pasien telah dipanggil']);
    }

    public function checkQueueStatus()
    {
        $queue = Queue::where('user_id', auth()->id())->where('status', 'called')->first();

        if ($queue) {
            return response()->json(['called' => true]);
        } else {
            return response()->json(['called' => false]);
        }
    }

    public function selesaiPeriksa($id)
    {
        $queue = Queue::findOrFail($id);
        $queue->status = 'selesai';
        $queue->save();
        return response()->json(['status' => 'success', 'message' => 'Antrean pasien ini telah selesai']);
    }
}
