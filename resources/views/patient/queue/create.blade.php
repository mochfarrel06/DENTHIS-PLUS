@extends('layouts.master')

@section('title-page')
    Tambah
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Data Antrean</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('data-patient.queue.index') }}">Antrean</a></li>
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
                        <form id="main-form" method="POST" action="">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Dokter</label>
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Tanggal</label>
                                            <input type="date" class="form-control" min="" id="date">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Janji temu tersedia</label>
                                            <div class="time-slot-box">
                                                <div class="container-time" id="time-slots">

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Keluhan Pasien</label>
                                            <textarea name="" id="" cols="30" rows="5" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" id="submit-btn" class="btn btn-primary mr-2">Submit</button>
                                <a href="{{ route('data-patient.queue.index') }}" class="btn btn-warning">Kembali</a>
                            </div>
                        </form>

                    </div>
                </section>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#doctor_id, #date').on('change', function() {
                var doctorId = $('#doctor_id').val();
                var date = $('#date').val();

                if (doctorId && date) {
                    $.ajax({
                        url: "{{ route('data-patient.queue.create') }}",
                        method: 'GET',
                        data: {
                            doctor_id: doctorId,
                            date: date
                        },
                        success: function(response) {
                            $('#time-slots').html('');
                            if (response.length > 0) {
                                response.forEach(function(slot) {
                                    let btnClass = slot.is_booked ? 'btn-danger' :
                                        'btn-success';
                                    let isDisabled = slot.is_booked ? 'disabled' : '';
                                    $('#time-slots').append(
                                        `<a href="#" class="btn ${btnClass} m-1" ${isDisabled} data-start="${slot.start}" data-end="${slot.end}">
                                    ${slot.start} - ${slot.end}
                                </a>`
                                    );
                                });
                            } else {
                                $('#time-slots').html('<p>No available slots</p>');
                            }
                        }
                    });
                } else {
                    $('#time-slots').html('');
                }
            });

            // Optional: Tambahkan event listener untuk menangani klik pada tombol yang tersedia
            $('#time-slots').on('click', 'a:not(.btn-danger)', function(e) {
                e.preventDefault();
                var startTime = $(this).data('start');
                var endTime = $(this).data('end');
                alert(`Slot selected: ${startTime} - ${endTime}`);
            });
        });
    </script>

    <script>
        document.getElementById('date').min = new Date().toISOString().split('T')[0];
    </script>
@endpush
