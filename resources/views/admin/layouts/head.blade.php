<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Dynamic Title & Basic Meta -->
    <title>@yield('title', 'Dashboard') | {{ $siteSetting?->site_name ?? config('app.name', 'Themart') }}</title>
    <meta name="description" content="{{ $siteSetting?->meta_description }}">
    <meta name="keywords" content="{{ $siteSetting?->meta_keywords }}">
    <meta name="author" content="{{ $siteSetting?->meta_author ?? 'wpOceans' }}">

    <!-- Dynamic Favicon -->
    @if ($siteSetting?->favicon)
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/' . $siteSetting->favicon) }}">
    @else
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon.ico') }}">
    @endif
    <!-- core:css -->
    <link rel="stylesheet" href="{{ asset('backend/assets/vendors/core/core.css') }}">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <link rel="stylesheet"
        href="{{ asset('backend/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <!-- end plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('backend/assets/fonts/feather-font/css/iconfont.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/demo_1/style.css') }}">
    <!-- End layout styles -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css"
        integrity="sha512-QeR2VH+lsBE5LSAe1Q5EnTBbe7XTBubt8dG93Y7gidSgdMCr8nVqKcfKAMyN96SV8KDbZVTDXChatu5G2KQGzg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    @stack('style')


</head>
