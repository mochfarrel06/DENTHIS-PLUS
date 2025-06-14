<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\DoctorScheduleController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SpecializationController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Doctor\DashboardController as DoctorDashboardController;
use App\Http\Controllers\Doctor\MedicalRecordController;
use App\Http\Controllers\Patient\DashboardController as PatientDashboardController;
use App\Http\Controllers\Patient\QueueController;
use App\Http\Controllers\Patient\QueueHistoryController;
use App\Http\Controllers\Profile\ProfileController;
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

// 1. Route Auth
Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'store'])->name('login.store');
Route::post('logout', [LoginController::class, 'destroy'])->name('login.destroy');

Route::get('register', [LoginController::class, 'indexRegister'])->name('register');
Route::post('register', [LoginController::class, 'storeRegister'])->name('register.store');
Route::get('forgot-password', [LoginController::class, 'indexForgot'])->name('forgot-password');


// Verification
Route::group(['middleware' => ['role:pasien']], function() {
    Route::get('verify', [VerificationController::class, 'index'])->name('verify');
    Route::post('send-otp',[VerificationController::class, 'send_otp'])->name('send_otp');
    Route::get('verify/{unique_id}', [VerificationController::class, 'show'])->name('verify.show');
    Route::put('verify/{unique_id}', [VerificationController::class, 'update'])->name('verify.update');
});

Route::get('/forgot-password', [VerificationController::class, 'forgotPasswordForm'])->name('forgot.password');
Route::post('/forgot-password', [VerificationController::class, 'sendForgotPasswordOtp'])->name('forgot.password.send');
Route::get('/reset-password/{unique_id}', [VerificationController::class, 'resetPasswordForm'])->name('reset.password');
Route::post('/reset-password/{unique_id}', [VerificationController::class, 'resetPassword'])->name('reset.password.submit');

// 2. Route User
Route::get('/', [UserController::class, 'index'])->name('home');
Route::get('/dokter', [UserController::class, 'indexDokter'])->name('index-dokter');
Route::get('/tentang-kami', [UserController::class, 'indexTentangKami'])->name('index-tentangKami');

// 3. Route admin
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
    Route::resource('specializations', SpecializationController::class);

    Route::get('user-management', [UserManagementController::class, 'index'])->name('user-management.index');
    Route::get('user-management/create', [UserManagementController::class, 'create'])->name('user-management.create');
    Route::post('user-management', [UserManagementController::class, 'store'])->name('user-management.store');
    Route::get('user-management/{id}/edit', [UserManagementController::class, 'edit'])->name('user-management.edit');
    Route::put('user-management/{id}', [UserManagementController::class, 'update'])->name('user-management.update');
    Route::delete('user-management/{id}', [UserManagementController::class, 'destroy'])->name('user-management.destroy');

    Route::get('header-setting', [SettingController::class, 'edit_header'])->name('header-setting.edit');
    Route::put('header-setting', [SettingController::class, 'update_header'])->name('header-setting.update');
});

// 4. Route patient
Route::group(['prefix' => 'patient', 'as' => 'patient.', 'middleware' => ['role:pasien', 'check.status']], function () {
    Route::get('dashboard', [PatientDashboardController::class, 'index'])->name('dashboard');
});

// 5. Route queue
Route::group([
    'prefix' => 'data-patient',
    'as' => 'data-patient.',
    'middleware' => ['role:pasien,admin,dokter']
], function () {
    // Route::resource('queue', QueueController::class);
    Route::get('queue', [QueueController::class, 'index'])->name('queue.index');
    Route::get('queue/create', [QueueController::class, 'create'])->name('queue.create')->middleware('role:pasien');
    Route::post('queue', [QueueController::class, 'store'])->name('queue.store')->middleware('role:pasien,dokter');
    Route::get('queue/{id}', [QueueController::class, 'show'])->name('queue.show');
    Route::delete('queue/{id}', [QueueController::class, 'destroy'])->name('queue.destroy')->middleware('role:pasien,admin');
    Route::post('call-patient/{id}', [QueueController::class, 'callPatient'])->name('queue.callPatient')->middleware('role:admin');
    Route::get('/queue/check-status', [QueueController::class, 'checkQueueStatus'])->name('queue.checkStatus');
    Route::post('selesai-periksa/{id}', [QueueController::class, 'selesaiPeriksa'])->name('queue.selesaiPeriksa');
    Route::post('periksa-pasien/{id}', [QueueController::class, 'periksaPasien'])->name('queue.periksaPasien');
    Route::post('batal-antrean/{id}', [QueueController::class, 'batalAntrean'])->name('queue.batalAntrean')->middleware('role:pasien,admin,dokter');

    Route::get('create-antrean-khusus', [QueueController::class, 'createAntreanKhusus'])->name('createAntreanKhusus');
    Route::post('store-antrean-khusus', [QueueController::class, 'storeAntreanKhusus'])->name('storeAntreanKhusus');
});

// 6. Route history
Route::group(['prefix' => 'history', 'as' => 'history.', 'middleware' => 'role:admin,dokter,pasien'], function() {
    Route::get('/queue', [QueueHistoryController::class, 'index'])->name('history.index');
    Route::get('/queue/pdf', [QueueHistoryController::class, 'exportPdf'])->name('pdf');
    Route::get('queue/{id}', [QueueHistoryController::class, 'show'])->name('queue-history.show');
    Route::get('/queue/medical-record/{id}/pdf', [QueueHistoryController::class, 'generatePDF'])->name('history-medical.pdf');
});

// 7. Route doctor
Route::group(['prefix' => 'doctor', 'as' => 'doctor.', 'middleware' => 'role:dokter,pasien,admin'], function () {
    Route::get('dashboard', [DoctorDashboardController::class, 'index'])->name('dashboard')->middleware('role:dokter');

    Route::get('/medical-record', [MedicalRecordController::class, 'index'])->name('medical-record.index')->middleware('role:pasien,dokter,admin');
    Route::get('/medical-record/create', [MedicalRecordController::class, 'create'])->name('medical-record.create')->middleware('role:dokter');
    Route::post('/medical-record/store', [MedicalRecordController::class, 'store'])->name('medical-record.store')->middleware('role:dokter');
    Route::get('/medical-record/{id}', [MedicalRecordController::class, 'show'])->name('medical-record.show')->middleware('role:pasien,dokter,admin');

    Route::get('/medical-record/{id}/pdf', [MedicalRecordController::class, 'generatePDF'])->name('medical-record.pdf');
});

// 8. Route Profil
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'middleware' => 'role:pasien,admin,dokter'], function () {
    Route::get('dashboard', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('update', [ProfileController::class, 'update'])->name('profile.update');
});
