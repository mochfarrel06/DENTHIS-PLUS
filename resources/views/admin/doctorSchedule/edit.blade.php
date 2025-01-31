@extends('layouts.master')

@section('title-page')
    Edit
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Jadwal Dokter</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.doctor-schedules.index') }}">Jadwal Dokter</a>
                        </li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-12">
                    <div class="card">
                        <form method="POST" action="{{ route('admin.doctor-schedules.update', $doctor->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Profile</label>
                                            <div>
                                                <!-- Gambar profil -->
                                                <img class="profile-user-img img-fluid img-circle"
                                                    src="{{ $doctor->foto_dokter ? asset($doctor->foto_dokter) : asset('assets/admin/dist/img/avatar.png') }}"
                                                    alt="User profile picture"
                                                    style="cursor: pointer; object-fit: cover; width: 100px; height: 100px; border-radius: 50%;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Waktu Jeda</label>
                                            <select name="waktu_jeda" id="waktu_jeda" class="form-control">
                                                <option value="">-- Pilih Waktu Jeda --</option>
                                                <option value="5"
                                                    {{ $firstSchedule && $firstSchedule->waktu_jeda === 5 ? 'selected' : '' }}>
                                                    5 Menit</option>
                                                <option value="10"
                                                    {{ $firstSchedule && $firstSchedule->waktu_jeda === 10 ? 'selected' : '' }}>
                                                    10 Menit</option>
                                                <option value="15"
                                                    {{ $firstSchedule && $firstSchedule->waktu_jeda === 15 ? 'selected' : '' }}>
                                                    15 Menit</option>
                                                <option value="30"
                                                    {{ $firstSchedule && $firstSchedule->waktu_jeda === 30 ? 'selected' : '' }}>
                                                    30 Menit</option>
                                                <option value="60"
                                                    {{ $firstSchedule && $firstSchedule->waktu_jeda === 60 ? 'selected' : '' }}>
                                                    1 Jam</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Waktu Pertemuan</label>
                                            <select name="waktu_periksa" id="waktu_periksa" class="form-control">
                                                <option value="">-- Pilih Waktu Periksa --</option>
                                                <option value="5"
                                                    {{ $firstSchedule && $firstSchedule->waktu_periksa === 5 ? 'selected' : '' }}>
                                                    5 Menit</option>
                                                <option value="10"
                                                    {{ $firstSchedule && $firstSchedule->waktu_periksa === 10 ? 'selected' : '' }}>
                                                    10 Menit</option>
                                                <option value="15"
                                                    {{ $firstSchedule && $firstSchedule->waktu_periksa === 15 ? 'selected' : '' }}>
                                                    15 Menit</option>
                                                <option value="30"
                                                    {{ $firstSchedule && $firstSchedule->waktu_periksa === 30 ? 'selected' : '' }}>
                                                    30 Menit</option>
                                                <option value="60"
                                                    {{ $firstSchedule && $firstSchedule->waktu_periksa === 60 ? 'selected' : '' }}>
                                                    1 Jam</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                        <div class="col-md-12 mb-3">
                                            <div class="form-check">
                                                <input type="checkbox" name="hari[]" value="{{ $day }}"
                                                    id="{{ $day }}"
                                                    {{ isset($formattedSchedules[$day]['jam_mulai']) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="{{ $day }}">{{ $day }}</label>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="start_time_{{ $day }}">Start Time</label>
                                                    <input type="time" name="jam_mulai[{{ $day }}]"
                                                        id="start_time_{{ $day }}" class="form-control"
                                                        value="{{ $formattedSchedules[$day]['jam_mulai'] }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="end_time_{{ $day }}">End Time</label>
                                                    <input type="time" name="jam_selesai[{{ $day }}]"
                                                        id="end_time_{{ $day }}" class="form-control"
                                                        value="{{ $formattedSchedules[$day]['jam_selesai'] }}">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" id="submit-btn" class="btn btn-primary mr-2">Simpan</button>
                                <a href="{{ route('admin.doctor-schedules.index') }}" class="btn btn-warning">Kembali</a>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </section>
@endsection
