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
            <a><b>Verification Email</b></a>
        </div>
        <div class="card">
            <div class="card-body login-card-body" style="padding-bottom: 30px">
                <p class="login-box-msg">Please verify your account</p>
                <form action="{{ route('send_otp') }}" method="POST">
                    @csrf
                    <input type="hidden" value="register" name="type">
                    <button type="submit" class="btn btn-sm btn-primary">Send OTP to your email</button>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/admin/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/admin/dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/izitoast/js/iziToast.min.js') }}"></script>
</body>

</html>
