<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\DoctorScheduleController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Doctor\DashboardController as DoctorDashboardController;
use App\Http\Controllers\Doctor\MedicalRecordController;
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

Route::get('register', [LoginController::class, 'indexRegister'])->name('register');
Route::post('register', [LoginController::class, 'storeRegister'])->name('register.store');
Route::get('forgot-password', [LoginController::class, 'indexForgot'])->name('forgot-password');

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
    'middleware' => ['role:pasien,admin,dokter']
], function () {
    // Route::resource('queue', QueueController::class);
    Route::get('queue', [QueueController::class, 'index'])->name('queue.index');
    Route::get('queue/create', [QueueController::class, 'create'])->name('queue.create')->middleware('role:pasien');
    Route::post('queue', [QueueController::class, 'store'])->name('queue.store')->middleware('role:pasien');
    Route::delete('queue/{id}', [QueueController::class, 'destroy'])->name('queue.destroy')->middleware('role:pasien,admin');
    Route::post('call-patient/{id}', [QueueController::class, 'callPatient'])->middleware('role:admin');
    Route::get('/queue/check-status', [QueueController::class, 'checkQueueStatus'])->name('queue.checkStatus');
    Route::post('selesai-periksa/{id}', [QueueController::class, 'selesaiPeriksa']);
});

Route::group(['prefix' => 'doctor', 'as' => 'doctor.', 'middleware' => 'role:dokter'], function () {
    Route::get('dashboard', [DoctorDashboardController::class, 'index'])->name('dashboard');

    Route::get('/medical-records', [MedicalRecordController::class, 'index'])->name('medical-record.index');
    Route::get('/medical-record/create', [MedicalRecordController::class, 'create'])->name('medical-record.create');
    Route::post('/medical-record/store', [MedicalRecordController::class, 'store'])->name('medical-record.store');
    Route::get('/medical-record/{queueId}', [MedicalRecordController::class, 'show'])->name('medical-record.show');
});
