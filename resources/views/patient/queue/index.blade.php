@extends('layouts.master')

@section('title-page')
    Antrean
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Antrean</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    {{-- @if (auth()->user()->role == 'admin')
                        <button class="btn btn-primary" onclick="callPatient({{ $queue->id }})">Panggil Pasien</button>
                    @endif --}}
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    {{-- @foreach ($queues as $queue)
                        @if ($queue->status == 'called' && $queue->user_id == auth()->id())
                            <div class="alert alert-info alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert"
                                    aria-hidden="true">&times;</button>
                                <h5><i class="icon fas fa-info"></i> Info</h5>
                                Antrean Anda sudah dipanggil oleh dokter.
                            </div>
                        @endif
                    @endforeach --}}

                    @if ($userQueue)
                        <div class="alert alert-info alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-info"></i> Info</h5>
                            Antrean Anda sudah dipanggil oleh dokter.
                        </div>

                        {{-- <div id="queue-alert" class="alert alert-info alert-dismissible" style="display: none;">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-info"></i> Info</h5>
                            Antrean Anda sudah dipanggil oleh dokter.
                        </div> --}}
                    @endif

                    {{-- <div class="ml-auto">
                        <button type="button" class="btn btn-primary d-flex align-items-center" style="gap: 5px"><i
                                class="iconoir-filter-solid"></i>Filter</button>
                    </div> --}}

                </div>
            </div>
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
                            @endif
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Dokter</th>
                                        <th>Janji Temu</th>
                                        <th>Status</th>
                                        @if (auth()->user() && (auth()->user()->role == 'pasien' || auth()->user()->role == 'admin'))
                                            <th>Aksi</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($queues as $queue)
                                        <tr>
                                            <td>{{ $queue->doctor->nama_depan }} {{ $queue->doctor->nama_belakang }}</td>
                                            <td>{{ $queue->start_time }} - {{ $queue->end_time }}</td>
                                            <td>{{ $queue->status }}</td>
                                            @if (auth()->user() && (auth()->user()->role == 'pasien' || auth()->user()->role == 'admin'))
                                                <td>
                                                    <div class="btn-group">
                                                        <a data-toggle="dropdown">
                                                            <i class="iconoir-more-vert"></i>
                                                        </a>
                                                        <ul class="dropdown-menu">
                                                            {{-- <li><a class="dropdown-item"
                                                                href="{{ route('queues.show', $queue->id) }}">Detail</a>
                                                        </li>
                                                        <li><a class="dropdown-item"
                                                                href="{{ route('queues.edit', $queue->id) }}">Edit</a>
                                                        </li> --}}
                                                            <li><a class="dropdown-item delete-item"
                                                                    href="{{ route('data-patient.queue.destroy', $queue->id) }}">Hapus</a>
                                                            </li>
                                                            <li>
                                                                @if (auth()->user()->role == 'admin')
                                                                    <button class="btn btn-primary"
                                                                        onclick="callPatient({{ $queue->id }})">Panggil
                                                                        Pasien</button>
                                                                @endif
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </section>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        function callPatient(queueId) {
            fetch(`/data-patient/call-patient/${queueId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert('Pasien telah dipanggil!');
                        location.reload();
                    } else {
                        alert('Gagal memanggil pasien!');
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
    <script>
        function checkQueueStatus() {
            $.ajax({
                url: "{{ route('data-patient.queue.checkStatus') }}",
                type: "GET",
                success: function(response) {
                    if (response.called) {
                        $('#queue-alert').show(); // Tampilkan notifikasi
                    }
                }
            });
        }

        // Jalankan AJAX setiap 5 detik (5000 milidetik)
        setInterval(checkQueueStatus, 5000);
    </script>
@endpush
