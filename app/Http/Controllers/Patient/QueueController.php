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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('patient.queue.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $doctors = Doctor::all();
        $patients = Patient::all();

        if ($request->has('doctor_id') && $request->has('date')) {
            $doctorId = $request->input('doctor_id');
            $date = $request->input('date');

            $dayOfWeek = \Carbon\Carbon::parse($date)->format('l');

            // Ambil jadwal dokter
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $userId = Auth::id();
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'urutan' => 'required',
            'tgl_periksa' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'status' => 'required|string',
            'is_booked' => 'required|boolean'
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
        $lastQueue = Queue::where('doctor_id', $request->doctor_id)
            ->where('tgl_periksa', $request->tgl_periksa)
            ->orderBy('urutan', 'desc')
            ->first();

        $urutan = $lastQueue ? $lastQueue->urutan + 1 : 1;

        // Simpan data antrean
        Queue::create([
            'user_id' => $userId,
            'doctor_id' => $request->doctor_id,
            'tgl_periksa' => $request->tgl_periksa,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'urutan' => $urutan,
            'status' => $request->status,
            'is_booked' => $request->is_booked
        ]);

        return redirect()->route('data-patient.queue.index')->with('success', 'Antrean berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
