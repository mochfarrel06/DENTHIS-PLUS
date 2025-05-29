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
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Grafik Antrean Pasien Berdasarkan Spesialisasi</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="chartAntrean" height="500"></canvas>
                        </div>
                    </div>
                </div>
            </div>

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
                        <a href="{{ route('admin.doctors.index') }}" class="small-box-footer">More info <i
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
                        <a href="{{ route('data-patient.queue.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $jumlahSpesialisasi }}</h3>

                            <p>Jumlah Spesialisasi</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{ route('admin.specializations.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>

            <div class="row">
                <section class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex">
                            <div class="d-flex align-items-center">
                                <i class="iconoir-table mr-2"></i>
                                <h3 class="card-title">Antrean Pasien
                                    <b>{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d-m-Y') }}</b></h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
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
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $queue->patient->kode_pasien }}</td>
                                            <td>{{ $queue->doctor->nama_depan }} {{ $queue->doctor->nama_belakang }}</td>
                                            <td>{{ $queue->patient->nama_depan }} {{ $queue->patient->nama_belakang }}
                                            </td>
                                            <td>
                                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $queue->start_time ?? $queue->waktu_mulai)->format('H:i') }}
                                                -
                                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $queue->end_time ?? $queue->waktu_selesai)->format('H:i') }}
                                            </td>

                                            <td>
                                                @if ($queue->status == 'booking')
                                                    <a class="btn btn-warning btn-sm">Booking</a>
                                                @elseif ($queue->status == 'periksa')
                                                    <a class="btn btn-info btn-sm">Periksa</a>
                                                @elseif ($queue->status == 'selesai')
                                                    <a class="btn btn-success btn-sm">Selesai</a>
                                                @elseif ($queue->status == 'batal')
                                                    <a class="btn btn-danger btn-sm">Batal</a>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const antreanPerHari = @json($antreanPerHari);
    const antreanPerBulan = @json($antreanPerBulan);
    const antreanPerTahun = @json($antreanPerTahun);

    const labels = [...new Set([
        ...antreanPerHari.map(item => item.poli),
        ...antreanPerBulan.map(item => item.poli),
        ...antreanPerTahun.map(item => item.poli)
    ])];

    const dataPerHari = labels.map(poli => {
        const found = antreanPerHari.find(item => item.poli === poli);
        return found ? found.jumlah : 0;
    });

    const dataPerBulan = labels.map(poli => {
        const found = antreanPerBulan.find(item => item.poli === poli);
        return found ? found.jumlah : 0;
    });

    const dataPerTahun = labels.map(poli => {
        const found = antreanPerTahun.find(item => item.poli === poli);
        return found ? found.jumlah : 0;
    });

    const ctx = document.getElementById('chartAntrean').getContext('2d');
    const antreanChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Hari Ini',
                    data: dataPerHari,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                },
                {
                    label: 'Bulan Ini',
                    data: dataPerBulan,
                    backgroundColor: 'rgba(255, 206, 86, 0.6)',
                },
                {
                    label: 'Tahun Ini',
                    data: dataPerTahun,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Antrean Berdasarkan Spesialisasi'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>
@endpush
