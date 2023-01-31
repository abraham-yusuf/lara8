<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="aplikasi bengkel shop">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="author" content="">
    <link href="{{ URL::asset('assets/ruangAdmin/img/logo/LOGO_CLS.jfif') }}" rel="icon">
    <title>MMTop Bakery | Login</title>
    <link href="{{ URL::asset('assets/ruangAdmin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ URL::asset('assets/ruangAdmin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ URL::asset('assets/ruangAdmin/css/ruang-admin.min.css') }}" rel="stylesheet">
</head>

<body class="bg-gradient-login">
    <!-- Login Content -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Login</h1>
                                    </div>
                                    @if (session()->has('pesan'))
                                        <div class="alert alert-danger text-center mb-4">{{ session('pesan') }}</div>
                                    @endif
                                    <form class="user" action="{{ route('aksi_login') }}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" name="username" class="form-control"
                                                id="exampleInputusername" aria-describedby="usernameHelp"
                                                placeholder="Enter Username Address">
                                            @error('username')
                                                <div class="text-danger text-sm">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control"
                                                id="exampleInputPassword" placeholder="Password">
                                            @error('password')
                                                <div class="text-danger text-sm">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            {{-- <div class="custom-control custom-checkbox small" style="line-height: 1.5rem;">
                        <input type="checkbox"  class="custom-control-input" id="customCheck">
                        <label class="custom-control-label" for="customCheck">Remember
                          Me</label>
                      </div> --}}
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                                        </div>
                                        <hr>
                                        {{-- <a href="index.html" class="btn btn-google btn-block">
                      <i class="fab fa-google fa-fw"></i> Login with Google
                    </a>
                    <a href="index.html" class="btn btn-facebook btn-block">
                      <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                    </a> --}}
                                    </form>
                                    <hr>
                                    {{-- <div class="text-center d-flex justify-content-around">
                    <a class="font-weight-bold small" href="{{route('register')}}">Create an Account!</a>
                    <a class="font-weight-bold small" href="register.html">Forget Password?</a>
                  </div> --}}
                                    <div class="text-center">
                                        <span class="font-weight-bold">MMTop Bakery</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login Content -->

</body>

</html>
