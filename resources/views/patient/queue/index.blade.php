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
                                        <th>Urutan Antrean</th>
                                        <th>Dokter</th>
                                        <th>Janji Temu</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($queues as $queue)
                                        <tr>
                                            <td>{{ $queue->urutan }}</td>
                                            <td>{{ $queue->doctor->nama_depan }} {{ $queue->doctor->nama_belakang }}</td>
                                            <td>{{ $queue->start_time }} - {{ $queue->end_time }}</td>
                                            <td>{{ $queue->status }}</td>
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
                                                    </ul>
                                                </div>
                                            </td>
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
