<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $siteSetting?->meta_description }}">
    <meta name="keywords" content="{{ $siteSetting?->meta_keywords }}">
    <meta name="author" content="{{ $siteSetting?->meta_author }}">
    {{-- <link rel="shortcut icon" type="image/png" href="{{ asset('frontend/assets/images/favicon.png') }}"> --}}

    <!-- Dynamic Favicon -->
    @if ($siteSetting?->favicon)
        <link rel="shortcut icon" type="image/png" href="{{ asset('storage/' . $siteSetting->favicon) }}">
    @endif

    <!-- Custom Head Scripts (Google Tag Manager / Analytics) -->
    {!! $siteSetting?->custom_head_script !!}

    <title>{{ $siteSetting?->site_title ?? ($siteSetting?->site_name ?? 'Themart') }}</title>
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

    @stack('style')

</head>
