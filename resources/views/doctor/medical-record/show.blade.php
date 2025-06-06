@extends('layouts.master')

@section('title-page')
    Detail
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Detail Rekam Medis</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('doctor.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('doctor.medical-record.index') }}">Rekam Medis</a></li>
                        <li class="breadcrumb-item active">Detail</li>
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
                        <form action="">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama Pasien</label>
                                            <input type="text" class="form-control"
                                                value="{{ $medicalRecord->user->nama_depan }} {{ $medicalRecord->user->nama_belakang }}"
                                                disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Umur</label>
                                            <input type="text" class="form-control"
                                                value="{{ \Carbon\Carbon::parse($medicalRecord->queue->patient->tgl_lahir)->age }} tahun"
                                                disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Diagnosis</label>
                                            <input type="text" class="form-control"
                                                value="{{ $medicalRecord->diagnosis }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Resep</label>
                                            <input type="text" class="form-control" value="{{ $medicalRecord->resep }}"
                                                disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Alergi</label>
                                            <textarea class="form-control" cols="30" rows="7" disabled>{{ $medicalRecord->user->alergi }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Catatan Medis</label>
                                            <textarea class="form-control" cols="30" rows="7" disabled>{{ $medicalRecord->catatan_medis }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                {{-- @if ($medicalRecord->dokumen)
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Dokumen Pendukung</label><br>
                                                <a class="d-flex align-items-center" href="{{ asset('dokumen_rekam_medis/' . $medicalRecord->dokumen) }}"
                                                    target="_blank"><i class="iconoir-download"></i> Download dokumen</a>
                                            </div>
                                        </div>
                                    </div>
                                @endif --}}
                                @php
                                    $dokumens = json_decode($medicalRecord->dokumen, true);
                                @endphp

                                @if (!empty($dokumens))
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Dokumen Pendukung</label>
                                                <ul>
                                                    @foreach ($dokumens as $dokumen)
                                                        <li>
                                                            <a href="{{ asset('dokumen_rekam_medis/' . $dokumen) }}"
                                                                target="_blank">
                                                                <i class="iconoir-download"></i> {{ $dokumen }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>
                            <div class="card-footer">
                                <a href="{{ route('doctor.medical-record.index') }}" class="btn btn-warning">Kembali</a>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </section>
@endsection
