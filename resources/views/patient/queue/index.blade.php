@extends('layouts.master')

@section('title-page')
    Antrean
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Antrean Pasien</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex">
                            <div class="d-flex align-items-center">
                                <i class="iconoir-table mr-2"></i>
                                <h3 class="card-title">Antrean Pasien</h3>
                            </div>

                            @if (auth()->user() && auth()->user()->role == 'pasien')
                                <div class="ml-auto">
                                    <a href="{{ route('data-patient.queue.create') }}"
                                        class="btn btn-primary d-flex align-items-center"><i
                                            class="iconoir-plus-circle mr-2"></i> Tambah</a>
                                </div>
                            @elseif (auth()->user() && auth()->user()->role == 'dokter')
                                <div class="ml-auto">
                                    <a href="{{ route('data-patient.createAntreanKhusus') }}"
                                        class="btn btn-primary d-flex align-items-center"><i
                                            class="iconoir-plus-circle mr-2"></i> Tambah</a>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Dokter</th>
                                        <th>Pasien</th>
                                        <th>Tanggal</th>
                                        <th>Janji Temu</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($queues as $queue)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $queue->doctor->nama_depan }} {{ $queue->doctor->nama_belakang }}</td>
                                            <td>{{ $queue->patient->nama_depan }} {{ $queue->patient->nama_belakang }}</td>
                                            <td>{{ \Carbon\Carbon::parse($queue->tgl_periksa)->format('d-m-Y') }}</td>
                                            <td>{{ \Carbon\Carbon::createFromFormat('H:i:s', $queue->start_time ?? $queue->waktu_mulai)->format('H:i') }}
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
                                            <td>
                                                <div class="btn-group">
                                                    <a data-toggle="dropdown">
                                                        <i class="iconoir-more-vert"></i>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item"
                                                                href="{{ route('data-patient.queue.show', $queue->id) }}"><i
                                                                    class="iconoir-eye-solid mr-2"></i> Detail</a>
                                                        </li>
                                                        @if (auth()->user()->role == 'dokter' && $queue->status == 'booking')
                                                            <li style="cursor: pointer">
                                                                <a class="dropdown-item"
                                                                    onclick="periksaPasien({{ $queue->id }})"><i
                                                                        class="iconoir-check mr-2"></i> Periksa</a>
                                                            </li>
                                                            {{-- @elseif (auth()->user()->role == 'dokter' && $queue->status == 'periksa')
                                                            <li>
                                                                <a class="dropdown-item" href=""
                                                                    onclick="selesaiPeriksa({{ $queue->id }})"><i
                                                                        class="iconoir-check mr-2"></i> Selesai Periksa</a>
                                                            </li> --}}
                                                        @elseif (auth()->user()->role == 'admin' || auth()->user()->role == 'pasien')
                                                            <li style="cursor: pointer"><a class="dropdown-item"
                                                                    onclick="batalAntrean({{ $queue->id }})"><i
                                                                        class="iconoir-xmark mr-2"></i> Batal</a>
                                                            </li>
                                                        @endif
                                                        {{-- <li style="cursor: pointer"><a class="dropdown-item"
                                                                onclick="batalAntrean({{ $queue->id }})"><i
                                                                    class="iconoir-xmark mr-2"></i> Batal</a>
                                                        </li> --}}
                                                    </ul>
                                                </div>
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
    <script>
        function selesaiPeriksa(queueId) {
            fetch(`/data-patient/selesai-periksa/${queueId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert('Pasien telah selesai periksa');
                        location.reload();
                    } else {
                        alert('Gagal selesai!');
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function periksaPasien(queueId) {
            Swal.fire({
                title: 'Yakin ingin periksa pasien sekarang?',
                text: "Tindakan ini akan memulai proses pemeriksaan pasien.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, periksa sekarang!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/data-patient/periksa-pasien/${queueId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content'),
                                'Content-Type': 'application/json'
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: data.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Gagal!', 'Tidak dapat memproses permintaan.', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire('Kesalahan!', 'Terjadi kesalahan pada server.', 'error');
                        });
                }
            });
        }

        function batalAntrean(queueId) {
            Swal.fire({
                title: 'Yakin ingin membatalkan antrean pasien?',
                text: "Tindakan ini akan membatalkan antrean pasien yang telah dilakukan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, batalkan antrean',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/data-patient/batal-antrean/${queueId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content'),
                                'Content-Type': 'application/json'
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: data.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Gagal!', 'Tidak dapat memproses permintaan.', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire('Kesalahan!', 'Terjadi kesalahan pada server.', 'error');
                        });
                }
            });
        }
    </script>
@endpush
