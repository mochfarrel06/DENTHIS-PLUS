<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

    <link href="{{ asset('assets/user/img/hospital.svg') }}" rel="icon" />

    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/izitoast/css/iziToast.min.css') }}">
</head>

<body class="hold-transition login-page">

    <div class="login-box">
        <div class="login-logo">
            <a><b>Verifikasi OTP Email</b></a>
        </div>
        <div class="card">
            <div class="card-body login-card-body" style="padding-bottom: 30px">
                <p class="login-box-msg">Harap masukkan kode otp email anda</p>

                <form action="{{ route('verify.update', $unique_id) }}" method="post">
                    @csrf
                    @method('PUT')


                    <div class="mb-3">
                        <input type="number" class="form-control @error('otp') is-invalid @enderror"
                            placeholder="Masukkan OTP" name="otp" value="{{ old('otp') }}">
                        @error('otp')
                            <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="row mt-4">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                        </div>
                    </div>
                </form>
                <p class="mb-1 mt-1">
                    <a href="{{ route('verify') }}">Kirim otp lagi?</a>
                </p>
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
</body>

</html>
