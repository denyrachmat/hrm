<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Login {{ getCompany()->app_name }}</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
    <meta content="" name="description">
    <meta content="" name="author">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('frontend/auth/css/vendor.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/auth/css/app.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="" crossorigin="anonymous" referrerpolicy="no-referrer">

    <style>
        .page_speed_807555265 {
            background-image: url('{{ asset('frontend/auth/img/login-bg-13.jpg') }}');
        }
    </style>
</head>

<body class="pace-top">
    <div id="app" class="app">
        <div class="login login-v2 fw-bold">
            <div class="login-cover">
                <div data-id="login-cover-image" class="login-cover-img page_speed_807555265"></div>
                <div class="login-cover-bg"></div>
            </div>
            <div class="login-container small-width">
                <div class="login-header">
                    <div class="brand">
                        <div class="d-flex align-items-center">{{ getCompany()->app_name }}</div>
                        <small>Reset Password</small>
                    </div>
                    <div class="icon">
                        <i class="fa fa-lock"></i>
                    </div>
                </div>
                <div class="login-content">
                    <form action="{{ route('reset-password') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                @if (session('error'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                <div class="form-floating mb-20px">
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <input type="hidden" name="email" value="{{ $email }}">
                                    <input type="password" name="password"
                                        class="form-control fs-13px h-45px border-0 password-form @error('password') is-invalid @enderror"
                                        placeholder="New Password" id="password" required value="">
                                    @error('password')
                                        <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                    <label for="password" class="d-flex align-items-center text-gray-600 fs-13px">New
                                        Password</label>
                                </div>

                                <div class="form-floating mb-20px">
                                    <input type="password" name="password_confirmation"
                                        class="form-control fs-13px h-45px border-0 password-form @error('password') is-invalid @enderror"
                                        placeholder="Confirm Password" id="password_confirmation" required>
                                    <label for="password_confirmation"
                                        class="d-flex align-items-center text-gray-600 fs-13px">Confirm Password</label>
                                </div>

                                <div class="form-check mb-20px">
                                    <div class="row">
                                        <div class="col-6">
                                            <input class="form-check-input border-0" type="checkbox" value="1"
                                                id="showPassword" onclick="togglePasswordVisibility()" />
                                            <label class="form-check-label fs-13px text-gray-300" for="showPassword">
                                                Show Password
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-20px">
                            <button type="submit" class="btn btn-cyan d-block w-100 h-45px btn-lg">Reset
                                Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top"
            data-toggle="scroll-to-top"><i class="fa fa-angle-up"></i></a>
    </div>
    <script src="{{ asset('frontend/auth/js/vendor.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('frontend/auth/js/app.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('frontend/auth/js/demo/login-v2.demo.js') }}" type="text/javascript"></script>
    <script>
        function togglePasswordVisibility() {
            var passwordInputs = document.querySelectorAll('.password-form');

            passwordInputs.forEach(function(input) {
                if (input.type === 'password') {
                    input.type = 'text';
                } else {
                    input.type = 'password';
                }
            });
        }
    </script>
    @include('sweetalert::alert')
</body>

</html>
