<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>

    <link href="{{ asset('assets/user/img/hospital.svg') }}" rel="icon" />

    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/izitoast/css/iziToast.min.css') }}">
    <style>
        @media (max-width: 576px) {
            .container {
                width: 90% !important;
            }
        }
    </style>
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-sm-12">
                <div class="login-logo">
                    <a><b>DENTHIS.PLUS</b></a>
                </div>
                <div class="card shadow-sm p-4">
                    <h4 class="text-center mb-5">Buat Akun Baru</h4>
                    <form id="main-form" method="POST" action="{{ route('register.store') }}"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3 mt-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Profil</label>
                                    <div>
                                        <img id="profileImage" class="profile-user-img img-fluid img-circle"
                                            src="{{ asset('assets/admin/dist/img/avatar.png') }}"
                                            alt="User profile picture"
                                            style="cursor: pointer; object-fit: cover; width: 120px; height: 120px; border-radius: 50%;">
                                        <input type="file" id="foto" name="foto" style="display: none;"
                                            accept="image/*">
                                    </div>
                                    @error('foto')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nama_depan" class="form-label">Nama Depan</label>
                                <input type="text" class="form-control @error('nama_depan') is-invalid @enderror"
                                    name="nama_depan" id="nama_depan" placeholder="Masukkan Nama Depan" value="{{ old('nama_depan') }}">
                                    @error('nama_depan')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="nama_belakang" class="form-label">Nama Belakang</label>
                                <input type="text" class="form-control @error('nama_belakang') is-invalid @enderror"
                                    name="nama_belakang" id="nama_belakang" placeholder="Masukkan Nama Belakang" value="{{ old('nama_belakang') }}">
                                    @error('nama_belakang')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" id="email" placeholder="Masukkan Email" value="{{ old('email') }}">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="no_hp" class="form-label">Nomor Kontak</label>
                                <input type="number" class="form-control @error('no_hp') is-invalid @enderror"
                                    name="no_hp" id="no_hp" placeholder="Masukkan Nomor Kontak" value="{{ old('no_hp') }}">
                                    @error('no_hp')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-6">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" id="password" placeholder="Masukkan Password" value="{{ old('password') }}">
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="konfirmasi_password" class="form-label">Konfirmasi Password</label>
                                <input type="password" class="form-control" name="konfirmasi_password"
                                    id="konfirmasi_password" placeholder="Masukkan Konfirmasi Password" value="{{ old('konfirmasi_password') }}">
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-6">
                                <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control @error('tgl_lahir') is-invalid @enderror"
                                    name="tgl_lahir" id="tgl_lahir" value="{{ old('tgl_lahir') }}">
                                    @error('tgl_lahir')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jenis Kelamin</label>
                                <div style="display: flex; gap: 20px; align-items: center;">
                                    <div class="custom-control custom-radio">
                                        <input
                                            class="custom-control-input custom-control-input-danger custom-control-input-outline @error('jenis_kelamin') is-invalid @enderror"
                                            type="radio" id="customRadioLaki" name="jenis_kelamin"
                                            value="Laki-Laki" {{ old('jenis_kelamin') == 'Laki-Laki' ? 'checked' : '' }}>
                                        <label for="customRadioLaki" class="custom-control-label">Laki-Laki</label>
                                        @error('jenis_kelamin')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input
                                            class="custom-control-input custom-control-input-danger custom-control-input-outline @error('jenis_kelamin') is-invalid @enderror"
                                            type="radio" id="customRadioPerempuan" name="jenis_kelamin"
                                            value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }}>
                                        <label for="customRadioPerempuan"
                                            class="custom-control-label">Perempuan</label>
                                            @error('jenis_kelamin')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-12">
                                <label for="alergi" class="form-label">Alergi</label>
                                <textarea name="alergi" id="alergi" rows="6" class="form-control @error('alergi') is-invalid @enderror" placeholder="Masukkan alergi">{{ old('alergi') }}</textarea>
                                @error('alergi')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>
                        </div>


                        <h5 class="mt-4">Informasi Alamat</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" class="form-control @error('alamat') is-invalid @enderror"
                                    name="alamat" id="alamat" placeholder="Masukkan Alamat" value="{{ old('alamat') }}">
                                    @error('alamat')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="negara" class="form-label">Negara</label>
                                <input type="text" class="form-control @error('negara') is-invalid @enderror"
                                    name="negara" id="negara" placeholder="Masukkan Negara" value="{{ old('negara') }}">
                                    @error('negara')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-6">
                                <label for="provinsi" class="form-label">Provinsi</label>
                                <input type="text" class="form-control @error('provinsi') is-invalid @enderror"
                                    name="provinsi" id="provinsi" placeholder="Masukkan Provinsi" value="{{ old('provinsi') }}">
                                    @error('provinsi')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="kota" class="form-label">Kota</label>
                                <input type="text" class="form-control @error('kota') is-invalid @enderror"
                                    name="kota" id="kota" placeholder="Masukkan Kota" value="{{ old('kota') }}">
                                    @error('kota')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-6">
                                <label for="kodepos" class="form-label">Kode Pos</label>
                                <input type="number" class="form-control @error('kodepos') is-invalid @enderror"
                                    name="kodepos" id="kodepos" placeholder="Masukkan Kode Pos" value="{{ old('kodepos') }}">
                                    @error('kodepos')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" id="submit-btn" class="btn btn-primary w-100">Daftar</button>
                        </div>
                    </form>

                    <p class="mb-1 mt-2">
                        <a href="{{ route('login') }}">Sudah memiliki akun?</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/admin/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/admin/dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/izitoast/js/iziToast.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            @if (session('success'))
                iziToast.success({
                    title: 'Berhasil',
                    message: '{{ session('success') }}',
                    position: 'topRight'
                });
            @endif

            @if (session('error'))
                iziToast.error({
                    title: 'Error',
                    message: '{{ session('error') }}',
                    position: 'topRight'
                });
            @endif

            @if (session('info'))
                iziToast.info({
                    title: 'Info',
                    message: '{{ session('info') }}',
                    position: 'topRight'
                });
            @endif
        });
    </script>

    <script>
        // Ambil elemen gambar dan input file
        const profileImage = document.getElementById('profileImage');
        const profileInput = document.getElementById('foto');

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

    <script></script>
</body>

</html>
