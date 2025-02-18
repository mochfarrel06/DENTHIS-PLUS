@extends('layouts.master')

@section('title-page')
    Dashboard
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $jumlahDokter }}</h3>

                            <p>Jumlah Dokter</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('admin.doctor-schedules.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $jumlahPasien }}</h3>

                            <p>Jumlah Pasien</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('admin.patients.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $jumlahAntrean }}</h3>

                            <p>Jumlah Antrean</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>

            <div class="row">
                <section class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex">
                            <div class="d-flex align-items-center">
                                <i class="iconoir-table mr-2"></i>
                                <h3 class="card-title">Antrean Pasien per hari</h3>
                            </div>

                            {{-- <div class="ml-auto">
                                <a class="btn btn-warning btn-sm">Booking</a>
                            </div> --}}
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Kode Pasien</th>
                                        <th>Dokter</th>
                                        <th>Pasien</th>
                                        <th>Waktu Periksa</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($antreanHariIni as $queue)
                                        <tr>
                                            <td>{{ $queue->user->name }}</td>
                                            <td>{{ $queue->doctor->nama_depan }} {{ $queue->doctor->nama_belakang }}</td>
                                            <td>{{ $queue->patient->nama_depan }} - {{ $queue->patient->nama_belakang }}
                                            </td>
                                            <td>{{ $queue->start_time }} - {{ $queue->end_time }}</td>
                                            <td>
                                                @if ($queue->status == 'booking')
                                                    <a class="btn btn-warning btn-sm">Booking</a>
                                                @elseif ($queue->status == 'dipanggil')
                                                    <a class="btn btn-info btn-sm">Di Panggil</a>
                                                @elseif ($queue->status == 'periksa')
                                                    <a class="btn btn-info btn-sm">Periksa</a>
                                                @elseif ($queue->status == 'Selesai')
                                                    <a class="btn btn-info btn-sm">Selesai</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
@endsection
