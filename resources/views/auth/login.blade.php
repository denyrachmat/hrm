<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset=utf-8>
    <title>Login {{ getCompany()->app_name }}</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name=viewport>
    <meta content="" name=description>
    <meta content="" name=author>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('frontend/auth/css/vendor.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/auth/css/app.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="" crossorigin=anonymous referrerpolicy="no-referrer">


    <style>
        .page_speed_807555265 {
            background-image: url({{ asset('frontend/auth/img/login-bg-13.jpg') }})
        }
    </style>
</head>

<body class='pace-top'>
    <div id="app" class="app">
        <div class="login login-v2 fw-bold">
            <div class="login-cover">
                <div data-id="login-cover-image"class="login-cover-img page_speed_807555265"></div>
                <div class="login-cover-bg"></div>
            </div>
            <div class="login-container small-width">
                <div class="login-header">
                    <div class="brand">
                        <div class="d-flex align-items-center">{{ getCompany()->app_name }}</b>
                        </div>
                        <small>Please login to start session</small>
                    </div>
                    <div class="icon">
                        <i class="fa fa-lock"></i>
                    </div>
                </div>
                <div class="login-content">
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-floating mb-20px">
                                    <input type=email name="email"
                                        class="form-control fs-13px h-45px border-0 @error('email') is-invalid @enderror"
                                        placeholder="Email" id="email" required value="{{ old('email') }}">
                                    @error('email')
                                        <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                    <label for="emailAddress"
                                        class="d-flex align-items-center text-gray-600 fs-13px">Email Address</label>
                                </div>

                                <div class="form-floating mb-20px">
                                    <input type=password name="password"
                                        class="form-control fs-13px h-45px border-0 @error('password') is-invalid @enderror"
                                        placeholder="Password" id="password" required autocomplete="new-password">
                                    <label for="emailAddress"
                                        class="d-flex align-items-center text-gray-600 fs-13px">Password</label>
                                </div>

                                <div class="form-check mb-20px">
                                    <div class="row">
                                        <div class="col-6">
                                            <input class="form-check-input border-0" type="checkbox" value="1"
                                                id="rememberMe" onclick="myFunction()" />
                                            <label class="form-check-label fs-13px text-gray-300" for="rememberMe">
                                                Show Password
                                            </label>

                                        </div>
                                        {{-- <div class="col-6">
                                            <div class="d-flex justify-content-end">
                                                <a class="text-right text-decoration-none"
                                                    href="{{ url('/forget-web') }}">Forgot Password ?</a>
                                            </div>
                                        </div> --}}
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="mb-20px">
                            <button type=submit class="btn btn-cyan d-block w-100 h-45px btn-lg">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top"
            data-toggle="scroll-to-top"><i class="fa fa-angle-up"></i></a>
    </div>
    <script src={{ asset('frontend/auth/js/vendor.min.js') }} type=1dcc4dafd62983dc732657cb-text/javascript></script>
    <script src={{ asset('frontend/auth/js/app.min.js') }} type=1dcc4dafd62983dc732657cb-text/javascript></script>
    <script src={{ asset('frontend/auth/js/demo/login-v2.demo.js') }} type=1dcc4dafd62983dc732657cb-text/javascript>
    </script>
    <script>
        function myFunction() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
    @include('sweetalert::alert')
</body>

</html>
