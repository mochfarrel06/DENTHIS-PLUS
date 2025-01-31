@extends('layouts.master')

@section('title-page')
    Tambah
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Jadwal Dokter</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.doctor-schedules.index') }}">Jadwal Dokter</a>
                        </li>
                        <li class="breadcrumb-item active">Tambah</li>
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
                        <form id="main-form" method="POST" action="{{ route('admin.doctor-schedules.store') }}">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Dokter</label>
                                            <select class="custom-select" name="doctor_id" id="doctor_id"
                                                @error('doctor_id') is-invalid @enderror">
                                                <option value="">-- Pilih Dokter --</option>
                                                @foreach ($doctors as $doctor)
                                                    <option value="{{ $doctor->id }}">{{ $doctor->nama_depan }}
                                                        {{ $doctor->nama_belakang }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Waktu Jeda</label>
                                            <select name="waktu_jeda" id="waktu_jeda" class="form-control"
                                                @error('waktu_jeda') is-invalid @enderror">
                                                <option value="">-- Pilih Waktu Jeda --</option>
                                                <option value="5">5 Menit</option>
                                                <option value="10">10 Menit</option>
                                                <option value="15">15 Menit</option>
                                                <option value="30">30 Menit</option>
                                                <option value="60">1 Jam</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Waktu Pertemuan</label>
                                            <select name="waktu_periksa" id="waktu_periksa" class="form-control"
                                                @error('waktu_periksa') is-invalid @enderror">
                                                <option value="">-- Pilih Waktu Periksa --</option>
                                                <option value="5">5 Menit</option>
                                                <option value="10">10 Menit</option>
                                                <option value="15">15 Menit</option>
                                                <option value="30">30 Menit</option>
                                                <option value="60">1 Jam</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                    <div class="col-md-12 mb-3">
                                        <div class="form-check">
                                            <input type="checkbox" name="hari[]" value="{{ $day }}"
                                                id="{{ $day }}">
                                            <label class="form-check-label"
                                                for="{{ $day }}">{{ $day }}</label>
                                        </div>
                                        @php
                                            // Membuat array rentang waktu (08:00 - 22:00) dengan interval 30 menit
                                            $times = [];
                                            $startTime = strtotime('08:00');
                                            $endTime = strtotime('22:00');

                                            while ($startTime <= $endTime) {
                                                $times[] = date('H:i', $startTime);
                                                $startTime = strtotime('+15 minutes', $startTime);
                                            }
                                        @endphp
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="start_time_{{ $day }}">Start Time</label>
                                                <select name="jam_mulai[{{ $day }}]"
                                                    id="start_time_{{ $day }}" class="form-control">
                                                    @foreach ($times as $time)
                                                        <option value="{{ $time }}">{{ $time }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="end_time_{{ $day }}">End Time</label>
                                                <select name="jam_selesai[{{ $day }}]"
                                                    id="end_time_{{ $day }}" class="form-control">
                                                    @foreach ($times as $time)
                                                        <option value="{{ $time }}">{{ $time }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>

                            <div class="card-footer">
                                <button type="submit" id="submit-btn" class="btn btn-primary mr-2">Submit</button>
                                <a href="{{ route('admin.doctor-schedules.index') }}" class="btn btn-warning">Kembali</a>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </section>
@endsection
