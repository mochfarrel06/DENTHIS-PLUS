@extends('layouts.master')

@section('title-page')
    Detail
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Detail Data Dokter</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.doctors.index') }}">Dokter</a></li>
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
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Profile</label>
                                            <div>
                                                <!-- Gambar profil -->
                                                <img id="profileImage" class="profile-user-img img-fluid img-circle"
                                                    src="{{ asset($doctor->foto_dokter) }}" alt="User Dokter"
                                                    style="cursor: pointer; object-fit: cover; width: 100px; height: 100px; border-radius: 50%;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nama_depan">Nama Depan</label>
                                            <input type="text" class="form-control" name="nama_depan" id="nama_depan"
                                                value="{{ $doctor->nama_depan }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nama_belakang">Nama Belakang</label>
                                            <input type="text" class="form-control" name="nama_belakang"
                                                id="nama_belakang" value="{{ $doctor->nama_belakang }}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" name="email" id="email"
                                                value="{{ $doctor->email }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="no_hp">Nomor Kontak</label>
                                            <input type="text" class="form-control" name="no_hp" id="no_hp"
                                                value="{{ $doctor->no_hp }}" disabled>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Password</label>
                                            <input type="password" name="password" id="password" class="form-control" value="{{ $doctor->nama_depan }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Konfirmasi Password</label>
                                            <input type="password" name="konfirmasi_password" id="konfirmasi_password"
                                                class="form-control" placeholder="Masukkan konfirmasi password">
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tgl_lahir">Tanggal Lahir</label>
                                            <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir"
                                                value="{{ $doctor->tgl_lahir }}" disabled />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="jenis_kelamin">Jenis Kelamin</label>
                                            <div style="display: flex; gap: 20px; align-items: center;">
                                                <div class="custom-control custom-radio">
                                                    <input
                                                        class="custom-control-input custom-control-input-danger custom-control-input-outline"
                                                        type="radio" id="customRadioLaki" name="jenis_kelamin"
                                                        value="Laki-Laki"
                                                        {{ $doctor->jenis_kelamin === 'Laki-Laki' ? 'checked' : '' }}
                                                        disabled>
                                                    <label for="customRadioLaki"
                                                        class="custom-control-label">Laki-Laki</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input
                                                        class="custom-control-input custom-control-input-danger custom-control-input-outline"
                                                        type="radio" id="customRadioPerempuan" name="jenis_kelamin"
                                                        value="Perempuan"
                                                        {{ $doctor->jenis_kelamin === 'Perempuan' ? 'checked' : '' }}
                                                        disabled>
                                                    <label for="customRadioPerempuan"
                                                        class="custom-control-label">Perempuan</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pengalaman">Pengalaman</label>
                                            <input type="text" class="form-control" name="pengalaman" id="pengalaman"
                                                value="{{ $doctor->pengalaman }} tahun" disabled />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Golongan Darah</label>
                                            <input type="text" class="form-control"
                                                value="{{ $doctor->golongan_darah }}" disabled>
                                        </div>
                                    </div>
                                </div>

                                <p class="font-bold mt-4">Informasi Alamat</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="alamat">Alamat</label>
                                            <input type="text" class="form-control" name="alamat" id="alamat"
                                                value="{{ $doctor->alamat }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="negara">Negara</label>
                                            <input type="text" class="form-control" name="negara" id="negara"
                                                value="{{ $doctor->negara }}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="provinsi">Provinsi</label>
                                            <input type="text" class="form-control" name="provinsi" id="provinsi"
                                                value="{{ $doctor->provinsi }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="kota">Kota</label>
                                            <input type="text" class="form-control" name="kota" id="kota"
                                                value="{{ $doctor->kota }}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="kodepos">Kode Pos</label>
                                            <input type="number" class="form-control" name="kodepos" id="kode_pos"
                                                value="{{ $doctor->kodepos }}" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <a href="{{ route('admin.doctors.index') }}" class="btn btn-warning">Kembali</a>
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
        // Ambil elemen gambar dan input file
        const profileImage = document.getElementById('profileImage');
        const profileInput = document.getElementById('foto_dokter');

        // Tambahkan event klik pada gambar
        profileImage.addEventListener('click', function() {
            profileInput.click(); // Simulasikan klik pada input file
        });

        // Update gambar saat file dipilih
        profileInput.addEventListener('change', function(event) {
            const file = event.target.files[0]; // Ambil file yang dipilih
            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    profileImage.src = e.target.result; // Perbarui src gambar
                };

                reader.readAsDataURL(file); // Baca file sebagai data URL
            }
        });
    </script>

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
@endpush
