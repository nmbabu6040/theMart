@extends('frontend.layouts.app')


@section('content')
    <!-- start wpo-page-title -->
    <section class="wpo-page-title">
        <h2 class="d-none">{{ __('Hide') }}</h2>
        <div class="container">
            <div class="row">
                <div class="col col-xs-12">
                    <div class="wpo-breadcumb-wrap">
                        <ol class="wpo-breadcumb-wrap">
                            <li><a href="{{ route('home.index') }}">{{ __('Home') }}</a></li>
                            <li>{{ __('About Us') }}</li>
                        </ol>
                    </div>
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>
    <!-- end page-title -->

    <!-- start of wpo-about-section -->
    <section class="wpo-about-section section-padding">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="wpo-about-wrap">
                        <div class="wpo-about-img">
                            @if (isset($about->image))
                                <img src="{{ asset($about->image) }}" alt="{{ $about->title }}">
                            @else
                                <img src="{{ asset('frontend/assets/images/about/1.jpg') }}" alt="{{ $about->title }}">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="wpo-about-text">
                        <h4>{{ $about->sub_title }}</h4>
                        <h2>{{ $about->title }}</b>
                        </h2>
                        <p>{{ $about->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end of wpo-about-section -->

    <!-- start wpo-service-section -->
    <section class="wpo-service-section">
        <div class="container">
            <div class="service-wrap">
                <div class="row">

                    @foreach ($services as $service)
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="service-item">
                                <div class="service-item-img">
                                    @if (isset($service->image))
                                        <img src="{{ asset($service->image) }}" alt="">
                                    @else
                                        <img src="{{ asset('frontend/assets/images/service/1.png') }}" alt="">
                                    @endif

                                </div>
                                <div class="service-item-text">
                                    <h2>{{ $service->title }}</h2>
                                    <p>{{ $service->description }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </section>
    <!-- end wpo-service-section -->

    <!-- start themart-gallery-section-->
    <section class="themart-gallery-section themart-gallery-section-s2 section-padding" id="gallery">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="wpo-section-title">
                        <h2>{{ __('Image Gallery') }}</h2>
                    </div>
                </div>
            </div>
            <div class="sortable-gallery">
                <div class="gallery-filters"></div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="portfolio-grids gallery-container clearfix">
                            @foreach ($galleries as $gallery)
                                <div class="grid">
                                    <div class="img-holder">
                                        <a href="{{ asset($gallery->image) }}" class="fancybox"
                                            data-fancybox-group="gall-1">
                                            @if (isset($gallery->image))
                                                <img src="{{ asset($gallery->image) }}" alt=""
                                                    class="img img-responsive">
                                            @else
                                                <img src="{{ asset('frontend/assets/images/portfolio/1.jpg') }}"
                                                    alt="" class="img img-responsive">
                                            @endif

                                            <div class="hover-content">
                                                <i class="fi flaticon-eye"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end themart-gallery-section-->


    <!-- start of themart-cta-section -->
    <section class="themart-cta-section section-padding">
        <div class="container">
            <div class="cta-wrap">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-12">
                        <div class="cta-content">
                            <h2>Subscribe Our Newsletter & <br>
                                Get 30% Discounts For Next Order</h2>

                            {{-- Alert Messages --}}
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @error('email')
                                <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror

                            <form action="{{ route('subscribe') }}" method="POST">
                                @csrf
                                <div class="input-1">
                                    <input type="email" name="email" class="form-control" placeholder="Your Email..."
                                        value="{{ old('email') }}" required>
                                    <div class="submit clearfix">
                                        <button class="theme-btn-s2" type="submit">Subscribe</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end of themart-cta-section -->
    </div>
    <!-- end of page-wrapper -->
@endsection
