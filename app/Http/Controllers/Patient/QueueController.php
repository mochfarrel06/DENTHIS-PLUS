<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Patient;
use Illuminate\Http\Request;

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
                    $slots[] = [
                        'start' => $slotStart,
                        'end' => $slotEnd,
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
        //
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
