<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\DoctorScheduleController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Patient\DashboardController as PatientDashboardController;
use App\Http\Controllers\Patient\QueueController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'store'])->name('login.store');
Route::post('logout', [LoginController::class, 'destroy'])->name('login.destroy');

Route::get('/', [UserController::class, 'index'])->name('home');
Route::get('/dokter', [UserController::class, 'indexDokter'])->name('index-dokter');
Route::get('/tentang-kami', [UserController::class, 'indexTentangKami'])->name('index-tentangKami');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'role:admin'], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('doctors', DoctorController::class);

    Route::get('doctor-schedules', [DoctorScheduleController::class, 'index'])->name('doctor-schedules.index');
    Route::get('doctor-schedules/create', [DoctorScheduleController::class, 'create'])->name('doctor-schedules.create');
    Route::post('doctor-schedules', [DoctorScheduleController::class, 'store'])->name('doctor-schedules.store');
    Route::get('doctor-schedules/{doctorId}/edit', [DoctorScheduleController::class, 'edit'])->name('doctor-schedules.edit');
    Route::put('doctor-schedules/{doctorId}', [DoctorScheduleController::class, 'update'])->name('doctor-schedules.update');
    Route::delete('doctor-schedules/{doctorId}', [DoctorScheduleController::class, 'destroy'])->name('doctor-schedules.destroy');

    Route::resource('patients', PatientController::class);
});

Route::group(['prefix' => 'patient', 'as' => 'patient.', 'middleware' => 'role:pasien'], function () {
    Route::get('dashboard', [PatientDashboardController::class, 'index'])->name('dashboard');
});

Route::group([
    'prefix' => 'data-patient',
    'as' => 'data-patient.',
    'middleware' => ['role:pasien,admin']
], function () {
    // Route::resource('queue', QueueController::class);
    Route::get('queue', [QueueController::class, 'index'])->name('queue.index');
    Route::get('queue/create', [QueueController::class, 'create'])->name('queue.create');
});
