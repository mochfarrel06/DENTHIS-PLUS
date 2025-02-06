<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\DoctorScheduleStoreRequest;
use App\Http\Requests\Doctor\DoctorScheduleUpdateRequest;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use Illuminate\Http\Request;

class DoctorScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schedules = DoctorSchedule::with('doctor')
            ->whereIn('id', function ($query) {
                $query->selectRaw('MIN(id)')
                    ->from('doctor_schedules')
                    ->groupBy('doctor_id'); // Group by doctor_id untuk mendapatkan satu jadwal per dokter
            })
            ->get();
        return view('admin.doctorSchedule.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $doctors = Doctor::all();
        return view('admin.doctorSchedule.create', compact('doctors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DoctorScheduleStoreRequest $request)
    {
        try {
            $doctorId = $request->doctor_id;

            foreach ($request->hari as $index => $hari) {
                $jamMulai = $request->jam_mulai[$hari] ?? null;
                $jamSelesai = $request->jam_selesai[$hari] ?? null;

                // Jika salah satu waktu tidak diisi, lewati iterasi ini
                if (!$jamMulai || !$jamSelesai) {
                    continue;
                }

                // Periksa apakah jadwal dengan kombinasi ini sudah ada
                $existingSchedule = DoctorSchedule::where('doctor_id', $doctorId)
                    ->where('hari', $hari)
                    ->where('jam_mulai', $jamMulai)
                    ->where('jam_selesai', $jamSelesai)
                    ->first();

                if ($existingSchedule) {
                    continue;
                }

                // Buat jadwal baru
                DoctorSchedule::create([
                    'doctor_id' => $doctorId,
                    'hari' => $hari,
                    'jam_mulai' => $jamMulai,
                    'jam_selesai' => $jamSelesai,
                    'waktu_periksa' => $request->waktu_periksa,
                    'waktu_jeda' => $request->waktu_jeda,
                ]);
            }

            return redirect()
                ->route('admin.doctor-schedules.index')
                ->with('success', 'Data jadwal dokter berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Redirect kembali ke halaman sebelumnya dengan error message
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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
    public function edit($doctorId)
    {
        // Ambil data dokter
        $doctor = Doctor::findOrFail($doctorId);

        // Ambil jadwal dokter berdasarkan doctor_id
        $schedules = DoctorSchedule::where('doctor_id', $doctorId)
            ->get()
            ->groupBy('hari');

        $firstSchedule = $schedules->first() ? $schedules->first()->first() : null; // Cek jika ada jadwal pertama

        // Siapkan default data hari (Senin-Minggu)
        $defaultDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $formattedSchedules = [];

        foreach ($defaultDays as $day) {
            if (isset($schedules[$day])) {
                $schedule = $schedules[$day]->first();
                $formattedSchedules[$day] = [
                    'jam_mulai' => $schedule->jam_mulai ? \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i') : null,
                    'jam_selesai' => $schedule->jam_selesai ? \Carbon\Carbon::parse($schedule->jam_selesai)->format('H:i') : null,
                ];
            } else {
                $formattedSchedules[$day] = [
                    'jam_mulai' => null,
                    'jam_selesai' => null,
                ];
            }
        }

        return view('admin.doctorSchedule.edit', compact('doctor', 'formattedSchedules', 'firstSchedule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $doctorId)
    {
        try {
            // Validasi input
            $request->validate([
                'waktu_jeda' => 'nullable',
                'waktu_periksa' => 'nullable',
                'hari' => 'required|array',  // Hari yang dicentang
                'jam_mulai' => 'required|array',
                'jam_selesai' => 'required|array',
            ]);

            // Dapatkan semua jadwal dokter untuk hari-hari yang dicentang
            foreach ($request->hari as $hari) {
                $jamMulai = $request->jam_mulai[$hari] ?? null;
                $jamSelesai = $request->jam_selesai[$hari] ?? null;

                // Jika salah satu waktu tidak diisi, lewati iterasi ini
                if (!$jamMulai || !$jamSelesai) {
                    continue;
                }

                // Cari jadwal dokter yang sudah ada
                $schedule = DoctorSchedule::where('doctor_id', $doctorId)
                    ->where('hari', $hari)
                    ->first();

                if ($schedule) {
                    // Jika jadwal sudah ada, perbarui
                    $schedule->update([
                        'jam_mulai' => $jamMulai,
                        'jam_selesai' => $jamSelesai,
                        'waktu_periksa' => $request->waktu_periksa,
                        'waktu_jeda' => $request->waktu_jeda,
                    ]);
                } else {
                    // Jika jadwal tidak ditemukan, buat baru
                    DoctorSchedule::create([
                        'doctor_id' => $doctorId,
                        'hari' => $hari,
                        'jam_mulai' => $jamMulai,
                        'jam_selesai' => $jamSelesai,
                        'waktu_periksa' => $request->waktu_periksa,
                        'waktu_jeda' => $request->waktu_jeda,
                    ]);
                }
            }

            // Hapus jadwal dokter untuk hari yang tidak dicentang
            $checkedHolidays = $request->hari ?? [];  // Hari-hari yang dicentang
            DoctorSchedule::where('doctor_id', $doctorId)
                ->whereNotIn('hari', $checkedHolidays)  // Hari yang tidak dicentang
                ->delete();  // Hapus jadwal untuk hari tersebut

            // Redirect setelah update selesai
            return redirect()
                ->route('admin.doctor-schedules.index')
                ->with('success', 'Jadwal dokter berhasil diperbarui.');
        } catch (\Exception $e) {
            // Tangani error dan redirect ke halaman sebelumnya
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }





    /**
     * Remove the specified resource from storage.
     */
    public function destroy($doctorId)
    {
        try {
            // Cari semua jadwal dokter berdasarkan doctor_id
            $schedules = DoctorSchedule::where('doctor_id', $doctorId)->get();

            // Hapus semua jadwal yang ditemukan
            foreach ($schedules as $schedule) {
                $schedule->delete();
            }

            // Redirect ke halaman index dengan pesan sukses
            return redirect()->route('admin.doctor-schedules.index')
                ->with('success', 'Jadwal dokter berhasil dihapus.');
        } catch (\Exception $e) {
            // Jika ada kesalahan, kembalikan dengan pesan error
            return redirect()->route('doctor-schedules.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
