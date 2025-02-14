@extends('layouts.master')

@section('title-page')
    Tambah
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Data Dokter</h1>
                </div>
                {{-- <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.doctors.index') }}">Dokter</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div> --}}
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-12">
                    <div class="card">
                        <form id="main-form" method="POST" action="{{ route('doctor.medical-record.store') }}">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="queue_id">Pilih Pasien (Antrean Called)</label>
                                    <select name="queue_id" id="queue_id" class="form-control">
                                        <option value="">-- Pilih Pasien --</option>
                                        @foreach ($queues as $queue)
                                            <option value="{{ $queue->id }}">{{ $queue->id }} -
                                                {{ $queue->tgl_periksa }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="diagnosis">Diagnosis</label>
                                    <textarea name="diagnosis" class="form-control" required></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="resep">Perawatan</label>
                                    <textarea name="resep" class="form-control" required></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="catatan_medis">Catata</label>
                                    <textarea name="catatan_medis" class="form-control" required></textarea>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" id="submit-btn" class="btn btn-primary mr-2">Submit</button>
                                <a href="{{ route('doctor.medical-record.index') }}" class="btn btn-warning">Kembali</a>
                            </div>
                        </form>

                    </div>
                </section>
            </div>
        </div>
    </section>
@endsection

{{-- @push('scripts')
    <script>
        $(document).ready(function() {
            const $submitBtn = $('#submit-btn');
            $('#main-form').on('submit', function(event) {
                event.preventDefault();

                const form = $(this)[0];
                const formData = new FormData(form);

                $submitBtn.prop('disabled', true).text('Loading...');

                $.ajax({
                    url: form.action,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            sessionStorage.setItem('success',
                                'Data dokter berhasil disubmit.');
                            window.location.href =
                                "{{ route('admin.doctors.index') }}";
                        } else {
                            $('#flash-messages').html('<div class="alert alert-danger">' +
                                response.error + '</div>');
                        }
                    },
                    error: function(response) {
                        const errors = response.responseJSON.errors;
                        for (let field in errors) {
                            let input = $('[name=' + field + ']');
                            let error = errors[field][0];
                            input.addClass('is-invalid');
                            input.next('.invalid-feedback').remove();
                            input.after('<div class="invalid-feedback">' + error + '</div>');
                        }

                        const message = response.responseJSON.message ||
                            'Terdapat kesalahan pada proses dokter';
                        $('#flash-messages').html('<div class="alert alert-danger">' + message +
                            '</div>');
                    },
                    complete: function() {
                        $submitBtn.prop('disabled', false).text('Tambah');
                    }
                });
            });

            $('input, select, textarea').on('input change', function() {
                $(this).removeClass('is-invalid');
                $(this).next('.invalid-feedback').text('');
            });
        });
    </script>
@endpush --}}
