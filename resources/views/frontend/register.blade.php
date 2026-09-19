<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="N M Babu">

    <link rel="shortcut icon" type="image/png" href="{{ asset('frontend/assets/images/favicon.png') }}">

    <title>Create Account | Organic Shop</title>

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

                        <form class="wpo-accountWrapper" action="{{ route('register.store') }}" method="POST">
                            @csrf

                            {{-- Left Side --}}
                            <div class="wpo-accountInfo">

                                <div class="wpo-accountInfoHeader">

                                    <a href="{{ route('home.index') }}">
                                        <img src="{{ asset('frontend/assets/images/logo-2.svg') }}" alt="Organic Shop">
                                    </a>

                                    <a class="wpo-accountBtn" href="{{ route('login') }}">
                                        <span>Log in</span>
                                    </a>

                                </div>

                                <div class="image">
                                    <img src="{{ asset('frontend/assets/images/login.svg') }}" alt="Register">
                                </div>

                                <div class="back-home">
                                    <a class="wpo-accountBtn" href="{{ route('home.index') }}">
                                        <span>Back To Home</span>
                                    </a>
                                </div>

                            </div>

                            {{-- Register Form --}}
                            <div class="wpo-accountForm form-style">

                                <div class="fromTitle">
                                    <h2>Signup</h2>
                                    <p>Create your customer account</p>
                                </div>

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

                                {{-- Success --}}
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <div class="row">

                                    {{-- Name --}}
                                    <div class="col-lg-12 col-md-12 col-12">

                                        <label for="name">
                                            Full Name
                                        </label>

                                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                                            placeholder="Your name here.." autocomplete="name" maxlength="100" required>

                                    </div>

                                    {{-- Email --}}
                                    <div class="col-lg-12 col-md-12 col-12">

                                        <label for="email">
                                            Email
                                        </label>

                                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                                            placeholder="Your email here.." autocomplete="email" maxlength="255"
                                            required>

                                    </div>

                                    {{-- Password --}}
                                    <div class="col-lg-12 col-md-12 col-12">

                                        <div class="form-group">

                                            <label for="password">
                                                Password
                                            </label>

                                            <input class="pwd2" id="password" type="password" name="password"
                                                placeholder="Create a password" autocomplete="new-password" required>

                                            <span class="input-group-btn">
                                                <button class="btn btn-default reveal3" type="button"
                                                    aria-label="Show password">
                                                    <i class="ti-eye"></i>
                                                </button>
                                            </span>

                                        </div>

                                    </div>

                                    {{-- Confirm Password --}}
                                    <div class="col-lg-12 col-md-12 col-12">

                                        <div class="form-group">

                                            <label for="password_confirmation">
                                                Confirm Password
                                            </label>

                                            <input class="pwd3" id="password_confirmation" type="password"
                                                name="password_confirmation" placeholder="Confirm your password"
                                                autocomplete="new-password" required>

                                            <span class="input-group-btn">
                                                <button class="btn btn-default reveal2" type="button"
                                                    aria-label="Show password">
                                                    <i class="ti-eye"></i>
                                                </button>
                                            </span>

                                        </div>

                                    </div>

                                    {{-- Signup Button --}}
                                    <div class="col-lg-12 col-md-12 col-12">

                                        <button type="submit" class="wpo-accountBtn">
                                            Signup
                                        </button>

                                    </div>

                                </div>

                                <p class="subText">
                                    Already have an account?
                                    <a href="{{ route('login') }}">
                                        Login
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
