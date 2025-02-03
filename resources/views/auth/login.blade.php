<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/admin/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/izitoast/css/iziToast.min.css') }}">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a><b>DENTHIS.PLUS</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body" style="padding-bottom: 100px">
                <p class="login-box-msg">Login untuk memulai aplikasi</p>

                <form action="{{ route('login.store') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email" name="email" id="email"
                            @error('email') is-invalid @enderror">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @error('email')
                            <div class="text-danger" style="font-size: 0.8em">*{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" id="password"
                            @error('password') is-invalid @enderror" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @error('password')
                            <div class="text-danger" style="font-size: 0.8em">*{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <div class="mt-3 text-center">
                    <button class="btn btn-secondary"
                        onclick="fillLogin('admin@example.com', 'password')">Admin</button>
                    <button class="btn btn-secondary"
                        onclick="fillLogin('pasien@example.com', 'password')">Pasien</button>
                    {{-- <button class="btn btn-secondary"
                        onclick="fillLogin('doctor@example.com', 'password')">Dokter</button> --}}
                </div>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{ asset('assets/admin/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
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
        function fillLogin(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
        }
    </script>
</body>

</html>
