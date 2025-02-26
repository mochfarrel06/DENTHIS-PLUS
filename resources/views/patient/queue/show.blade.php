@extends('layouts.master')

@section('title-page', 'Detail Antrean')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Detail Data Antrean</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('data-patient.queue.index') }}">Antrean</a></li>
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
                        <form>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 text-center">
                                        <img id="profileImage" class="profile-user-img img-fluid img-circle"
                                            src="{{ asset($queue->doctor->foto_dokter) }}" alt="User Dokter"
                                            style="cursor: pointer; object-fit: cover; width: 150px; height: 150px; border-radius: 50%;">
                                        <h3>{{ $queue->doctor->nama_depan }} - {{ $queue->doctor->nama_belakang }}</h3>
                                        <p>Dokter {{ $queue->doctor->spesialisasi }}</p>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h4>Informasi Antrean</h4>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <h5>Hari, Tanggal</h5>
                                                <p>{{ \Carbon\Carbon::parse($queue->tgl_periksa)->locale('id')->translatedFormat('l') }}, {{ $queue->tgl_periksa }}</p>
                                            </div>
                                            <div class="col-md-4">
                                                <h5>Janji Temu</h5>
                                                <p class="btn btn-info">{{ \Carbon\Carbon::createFromFormat('H:i:s', $queue->start_time)->format('H:i') }}
                                                    -
                                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $queue->end_time)->format('H:i') }}</p>
                                            </div>
                                            <div class="col-md-4">
                                                <h5>Status</h5>
                                                <p>@if ($queue->status == 'booking')
                                                    <a class="btn btn-warning btn-sm">Booking</a>
                                                @elseif ($queue->status == 'periksa')
                                                    <a class="btn btn-info btn-sm">Periksa</a>
                                                @elseif ($queue->status == 'selesai')
                                                    <a class="btn btn-success btn-sm">Selesai</a>
                                                @elseif ($queue->status == 'batal')
                                                    <a class="btn btn-danger btn-sm">Batal</a>
                                                @endif</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('data-patient.queue.index') }}" class="btn btn-warning">Kembali</a>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </section>
@endsection
