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
                <section class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex">
                            <div class="d-flex align-items-center">
                                <i class="iconoir-table mr-2"></i>
                                <h3 class="card-title">Dashboard Dokter</h3>
                            </div>

                            <div class="ml-auto">
                                <a href="{{ route('doctor.medical-record.create') }}"
                                    class="btn btn-primary d-flex align-items-center"><i
                                        class="iconoir-plus-circle mr-2"></i> Tambah</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Tanggal Periksa</th>
                                        <th>Dokter</th>
                                        <th>Diagnosis</th>
                                        <th>Perawatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($medicalRecords as $record)
                                        <tr>
                                            <td>{{ $record->tgl_periksa }}</td>
                                            <td>{{ $record->tgl_periksa }}</td>
                                            <td>{{ Str::limit($record->diagnosis, 30) }}</td>
                                            <td>{{ Str::limit($record->treatment, 30) }}</td>
                                            <td>
                                                {{-- <a href="{{ route('medical-record.show', $record->queue_id) }}"
                                                    class="btn btn-info btn-sm">
                                                    Lihat Detail
                                                </a> --}}
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
