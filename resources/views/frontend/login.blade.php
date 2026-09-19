<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="N M Babu">

    <link rel="shortcut icon" type="image/png" href="{{ asset('frontend/assets/images/favicon.png') }}">

    <title>Login | Organic Shop</title>

    <link href="{{ asset('frontend/assets/css/themify-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/flaticon_ecommerce.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/owl.carousel.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/owl.theme.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/slick.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/slick-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/swiper.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/owl.transitions.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/jquery.fancybox.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/odometer-theme-default.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/sass/style.css') }}" rel="stylesheet">
</head>

<body>

    <div class="page-wrapper">

        <div class="wpo-login-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">

                        <form class="wpo-accountWrapper" action="{{ route('login.store') }}" method="POST">
                            @csrf

                            {{-- Left Side --}}
                            <div class="wpo-accountInfo">

                                <div class="wpo-accountInfoHeader">

                                    <a href="{{ route('home.index') }}">
                                        <img src="{{ asset('frontend/assets/images/logo-2.svg') }}" alt="Organic Shop">
                                    </a>

                                    <a class="wpo-accountBtn" href="{{ route('register') }}">
                                        <span>Create Account</span>
                                    </a>

                                </div>

                                <div class="image">
                                    <img src="{{ asset('frontend/assets/images/login.svg') }}" alt="Login">
                                </div>

                                <div class="back-home">
                                    <a class="wpo-accountBtn" href="{{ route('home.index') }}">
                                        <span>Back To Home</span>
                                    </a>
                                </div>

                            </div>

                            {{-- Login Form --}}
                            <div class="wpo-accountForm form-style">

                                <div class="fromTitle">
                                    <h2>Login</h2>
                                    <p>Sign in to your account</p>
                                </div>

                                {{-- Success Message --}}
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                {{-- General Error --}}
                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                {{-- Validation Errors --}}
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0 ps-3">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="row">

                                    {{-- Email --}}
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <label for="email">Email</label>

                                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                                            placeholder="Enter your email" autocomplete="email" required>
                                    </div>

                                    {{-- Password --}}
                                    <div class="col-lg-12 col-md-12 col-12">

                                        <div class="form-group">

                                            <label for="password">Password</label>

                                            <input class="pwd6" id="password" type="password" name="password"
                                                placeholder="Enter your password" autocomplete="current-password"
                                                required>

                                            <span class="input-group-btn">
                                                <button class="btn btn-default reveal6" type="button"
                                                    aria-label="Show password">
                                                    <i class="ti-eye"></i>
                                                </button>
                                            </span>

                                        </div>

                                    </div>

                                    {{-- Remember / Forgot --}}
                                    <div class="col-lg-12 col-md-12 col-12">

                                        <div class="check-box-wrap">

                                            <div class="forget-btn">
                                                <a href="{{ route('forget-password') }}">
                                                    Forgot Password?
                                                </a>
                                            </div>

                                        </div>

                                    </div>

                                    {{-- Login Button --}}
                                    <div class="col-lg-12 col-md-12 col-12">

                                        <button type="submit" class="wpo-accountBtn">
                                            Login
                                        </button>

                                    </div>

                                </div>

                                <h4 class="or">
                                    <span>OR</span>
                                </h4>

                                {{-- Social Login --}}
                                <ul class="wpo-socialLoginBtn">

                                    <li>
                                        <button class="bg-danger" tabindex="0" type="button" disabled
                                            title="Google login coming soon">
                                            <span>
                                                <i class="ti-google"></i>
                                            </span>
                                        </button>
                                    </li>

                                    <li>
                                        <button class="bg-secondary" tabindex="0" type="button" disabled
                                            title="GitHub login coming soon">
                                            <span>
                                                <i class="ti-github"></i>
                                            </span>
                                        </button>
                                    </li>

                                </ul>

                                <p class="subText">
                                    Don't have an account?
                                    <a href="{{ route('register') }}">
                                        Create free account
                                    </a>
                                </p>

                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="{{ asset('frontend/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/modernizr.custom.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jquery.dlmenu.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jquery-plugin-collection.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/script.js') }}"></script>

</body>

</html>
