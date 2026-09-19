@extends('frontend.layouts.app')

@section('content')
    <!-- start of wpo-hero-section -->
    <div class="wpo-hero-slider">
        <div class="container container-fluid-sm">
            <div class="hero-slider">
                @foreach ($sliders as $slider)
                    <div class="hero-slider-item">
                        <div class="slider-bg">
                            <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title }}">
                        </div>
                        <div class="slider-content">
                            <div class="slide-title">
                                <h2>{{ $slider->title }}</h2>
                            </div>
                            <a class="theme-btn" href="{{ $slider->btn_link }}">{{ $slider->btn_text }}</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <ul class="hero-social">
            @if ($siteSetting?->facebook)
                <li><a href="{{ $siteSetting->facebook }}" target="_blank"><i class="ti-facebook"></i></a></li>
            @endif
            @if ($siteSetting?->twitter)
                <li><a href="{{ $siteSetting->twitter }}" target="_blank"><i class="ti-twitter-alt"></i></a></li>
            @endif
            @if ($siteSetting?->linkedin)
                <li><a href="{{ $siteSetting->linkedin }}" target="_blank"><i class="ti-linkedin"></i></a></li>
            @endif
            @if ($siteSetting?->instagram)
                <li><a href="{{ $siteSetting->instagram }}" target="_blank"><i class="ti-instagram"></i></a></li>
            @endif
            @if ($siteSetting?->youtube)
                <li><a href="{{ $siteSetting->youtube }}" target="_blank"><i class="ti-youtube"></i></a>
                </li>
            @endif
        </ul>
    </div>
    <!-- end of wpo-hero-section -->

    <!-- start of themart-featured-section -->
    <section class="themart-featured-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="wpo-section-title">
                        <h2>{{ __('Featured Categories') }}</h2>
                    </div>
                </div>
            </div>
            <div class="featured-categorie-slider owl-carousel">
                @if (isset($categories) && $categories->count() > 0)
                    @foreach ($categories as $category)
                        <div class="featured-item">
                            <div class="images">
                                <a href="{{ route('category.products', $category->slug) }}">
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}">
                                </a>
                            </div>
                            <div class="text">
                                <h2>
                                    <a href="{{ route('category.products', $category->slug) }}">
                                        {{ $category->name }}
                                    </a>
                                </h2>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
    <!-- end of themart-featured-section -->

    <!-- start of themart-offer-section -->
    <section class="themart-offer-section section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="wpo-section-title">
                        <h2>{{ __('Exciting Offers') }}</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($excitingOffers as $product)
                    <div class="col-lg-6 col-md-12">
                        <div class="offer-wrap">
                            <div class="content">
                                <h2>{{ $product->name }}</h2>
                                <span
                                    class="offer-price">${{ number_format($product->discount > 0 ? $product->discount_price : $product->sale_price, 2) }}</span>
                                @if ($product->discount > 0)
                                    <del>${{ number_format($product->sale_price, 2) }}</del>
                                @endif
                                <div class="count-up">
                                    <div id="clock"></div>
                                </div>
                                <a class="theme-btn-s2"
                                    href="{{ route('single-product', ['product' => $product->slug]) }}">{{ __('Shop Now') }}</a>
                            </div>

                        </div>
                    </div>
                @endforeach
                <div class="col-lg-6 col-md-12">
                    <div class="banner-two-wrap">
                        <div class="text">
                            <h2>{{ __('New Year Sale') }}</h2>
                            <h4>{{ __('Up To 70% Off') }}</h4>
                            <a class="theme-btn-s2" href="{{ route('home.shop') }}">{{ __('Shop Now') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end of themart-offer-section -->

    <!-- start of themart-interestproduct-section -->
    <section class="themart-interestproduct-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="wpo-section-title">
                        <h2>{{ __('Products Of Your Interest') }}</h2>
                    </div>
                </div>
            </div>
            <div class="product-wrap">
                <div class="row">
                    @php
                        // কারেন্সি ও এক্সচেঞ্জ রেট প্রসেসিং
                        $currency = session('currency', optional($setting)->currency_code ?? 'BDT');
                        $exchangeRate = 120; // 1 USD = 120 BDT (আপনার প্রয়োজন অনুযায়ী পরিবর্তন করতে পারেন)
                    @endphp

                    @forelse ($interestProducts as $product)
                        @php
                            // প্রাইস ক্যালকুলেশন
                            $rawPresentPrice = $product->discount > 0 ? $product->discount_price : $product->sale_price;
                            $rawOldPrice = $product->sale_price;

                            // কারেন্সি অনুযায়ী সিম্বল ও প্রাইস কনভার্সন
                            if ($currency == 'USD') {
                                $symbol = '$';
                                $presentPrice = number_format($rawPresentPrice / $exchangeRate, 2);
                                $oldPrice = number_format($rawOldPrice / $exchangeRate, 2);
                            } else {
                                $symbol = optional($setting)->currency_symbol ?? '৳';
                                $presentPrice = number_format($rawPresentPrice, 2);
                                $oldPrice = number_format($rawOldPrice, 2);
                            }
                        @endphp

                        <div class="col-lg-3 col-md-4 col-sm-6 col-12">

                            <div class="product-item">

                                <div class="image">

                                    @if ($product->images->isNotEmpty())
                                        <img src="{{ asset('storage/' . $product->thumbnail) }}"
                                            alt="{{ $product->name }}" class="img-fluid"
                                            style="width: 150px; height: 150px;">
                                    @else
                                        <img src="{{ asset('frontend/assets/images/interest-product/1.png') }}"
                                            alt="{{ $product->name }}">
                                    @endif


                                    @if ($product->discount > 0)
                                        <div class="tag sale">
                                            {{ __('Sale') }}
                                        </div>
                                    @elseif ($product->created_at->gt(now()->subDays(7)))
                                        <div class="tag new">
                                            {{ __('New') }}
                                        </div>
                                    @endif

                                </div>


                                <div class="text">

                                    <h2>
                                        <a href="{{ route('single-product', ['product' => $product->slug]) }}">
                                            {{ $product->name }}
                                        </a>
                                    </h2>


                                    <div class="rating-product">

                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <span>
                                            ({{ $product->reviews->count() }})
                                        </span>
                                    </div>


                                    <div class="price">
                                        <span class="present-price">
                                            {{ $symbol }}{{ $presentPrice }}
                                        </span>

                                        @if ($product->discount > 0)
                                            <del class="old-price">
                                                {{ $symbol }}{{ $oldPrice }}
                                            </del>
                                        @endif
                                    </div>


                                    <div class="shop-btn">

                                        <a class="theme-btn-s2"
                                            href="{{ route('single-product', ['product' => $product->slug]) }}">
                                            {{ __('Shop Now') }}
                                        </a>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="col-12 text-center">
                            <p>{{ __('No products found.') }}</p>
                        </div>
                    @endforelse
                    <div class="more-btn">
                        <a class="theme-btn-s2" href="{{ route('home.shop') }}">{{ __('View All') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end of themart-interestproduct-section -->

    <!-- start of themart-upcoming-offer-section -->
    <section class="themart-upcoming-offer-section section-padding">
        <div class="container">
            <div class="upcoming-offer">
                <div class="left-shape">
                    <svg width="448" height="448" viewBox="0 0 448 448" fill="none">
                        <path
                            d="M448 224C448 347.712 347.712 448 224 448C100.288 448 0 347.712 0 224C0 100.288 100.288 0 224 0C347.712 0 448 100.288 448 224ZM13.8949 224C13.8949 340.038 107.962 434.105 224 434.105C340.038 434.105 434.105 340.038 434.105 224C434.105 107.962 340.038 13.8949 224 13.8949C107.962 13.8949 13.8949 107.962 13.8949 224Z"
                            fill="#F1E2CC" />
                        <path
                            d="M405 224C405 323.964 323.964 405 224 405C124.036 405 43 323.964 43 224C43 124.036 124.036 43 224 43C323.964 43 405 124.036 405 224ZM56.2246 224C56.2246 316.66 131.34 391.775 224 391.775C316.66 391.775 391.775 316.66 391.775 224C391.775 131.34 316.66 56.2246 224 56.2246C131.34 56.2246 56.2246 131.34 56.2246 224Z"
                            fill="#F1E2CC" />
                        <path
                            d="M360 224C360 299.111 299.111 360 224 360C148.889 360 88 299.111 88 224C88 148.889 148.889 88 224 88C299.111 88 360 148.889 360 224ZM100.433 224C100.433 292.244 155.756 347.567 224 347.567C292.244 347.567 347.567 292.244 347.567 224C347.567 155.756 292.244 100.433 224 100.433C155.756 100.433 100.433 155.756 100.433 224Z"
                            fill="#F1E2CC" />
                    </svg>
                </div>
                <div class="left-image">
                    <img src="{{ asset('frontend/assets/images/upcomming-left.png') }}" alt="">
                </div>
                <div class="right-shape">
                    <svg width="448" height="448" viewBox="0 0 448 448" fill="none">
                        <path
                            d="M448 224C448 347.712 347.712 448 224 448C100.288 448 0 347.712 0 224C0 100.288 100.288 0 224 0C347.712 0 448 100.288 448 224ZM13.8949 224C13.8949 340.038 107.962 434.105 224 434.105C340.038 434.105 434.105 340.038 434.105 224C434.105 107.962 340.038 13.8949 224 13.8949C107.962 13.8949 13.8949 107.962 13.8949 224Z"
                            fill="#F1E2CC" />
                        <path
                            d="M405 224C405 323.964 323.964 405 224 405C124.036 405 43 323.964 43 224C43 124.036 124.036 43 224 43C323.964 43 405 124.036 405 224ZM56.2246 224C56.2246 316.66 131.34 391.775 224 391.775C316.66 391.775 391.775 316.66 391.775 224C391.775 131.34 316.66 56.2246 224 56.2246C131.34 56.2246 56.2246 131.34 56.2246 224Z"
                            fill="#F1E2CC" />
                        <path
                            d="M360 224C360 299.111 299.111 360 224 360C148.889 360 88 299.111 88 224C88 148.889 148.889 88 224 88C299.111 88 360 148.889 360 224ZM100.433 224C100.433 292.244 155.756 347.567 224 347.567C292.244 347.567 347.567 292.244 347.567 224C347.567 155.756 292.244 100.433 224 100.433C155.756 100.433 100.433 155.756 100.433 224Z"
                            fill="#F1E2CC" />
                    </svg>
                </div>
                <div class="right-image">
                    <img src="{{ asset('frontend/assets/images/upcomming-right.png') }}" alt="">
                </div>
                <div class="section-title-text">
                    <h2>{{ __('New Year Sale') }}</h2>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="text">
                            <div class="shape-text">Up To <div class="shape-single">
                                    <div class="shape">
                                        <svg width="158" height="159" viewBox="0 0 158 159" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M156.059 58C146.681 24.5386 115.956 0 79.5 0C35.5934 0 0 35.5934 0 79.5C0 123.407 35.5934 159 79.5 159C117.749 159 149.689 131.988 157.285 96H147.228C139.817 126.526 112.306 149.193 79.5 149.193C41.0096 149.193 9.80698 117.99 9.80698 79.5C9.80698 41.0096 41.0096 9.80698 79.5 9.80698C110.488 9.80698 136.752 30.031 145.814 58H156.059Z"
                                                fill="url(#paint0_linear_62_180)" />

                                            <defs>
                                                <linearGradient id="paint0_linear_62_180" x1="78.6428" y1="0"
                                                    x2="78.6428" y2="159" gradientUnits="userSpaceOnUse">
                                                    <stop offset="0" stop-color="#95CD2F" />
                                                    <stop offset="1" stop-color="#63911F" />
                                                </linearGradient>
                                            </defs>
                                        </svg>
                                    </div>
                                    50
                                </div>% Off</div>
                            <a class="upcoming-btn" href="{{ route('home.shop') }}">{{ __('Shop Now') }}</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- end of themart-upcoming-offer-section -->

    <!-- start of themart-special-product-section -->
    <section class="themart-special-product-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="wpo-section-title">
                        <h2>{{ __('Deals Of The Day') }}</h2>
                    </div>
                </div>
            </div>
            <div class="row g-0">

                @php
                    // কারেন্সি ও এক্সচেঞ্জ রেট প্রসেসিং
                    $currency = session('currency', optional($setting)->currency_code ?? 'BDT');
                    $exchangeRate = 120; // 1 USD = 120 BDT (আপনার প্রয়োজন অনুযায়ী পরিবর্তন করতে পারেন)
                @endphp

                @foreach ($bestDeals as $product)
                    @php
                        // প্রাইস ক্যালকুলেশন
                        $rawPresentPrice = $product->discount > 0 ? $product->discount_price : $product->sale_price;
                        $rawOldPrice = $product->sale_price;

                        // কারেন্সি অনুযায়ী সিম্বল ও প্রাইস কনভার্সন
                        if ($currency == 'USD') {
                            $symbol = '$';
                            $presentPrice = number_format($rawPresentPrice / $exchangeRate, 2);
                            $oldPrice = number_format($rawOldPrice / $exchangeRate, 2);
                        } else {
                            $symbol = optional($setting)->currency_symbol ?? '৳';
                            $presentPrice = number_format($rawPresentPrice, 2);
                            $oldPrice = number_format($rawOldPrice, 2);
                        }
                    @endphp

                    <div class="col-lg-6 col-12">
                        <ul class="special-product">
                            <li>
                                <div class="product-item">
                                    <div class="image w-50">

                                        @if ($product->images->isNotEmpty())
                                            <img src="{{ asset('storage/' . $product->thumbnail) }}" alt=""
                                                class="img-fluid" style="width: 280px; height: 280px;">
                                        @else
                                            <img src="{{ asset('frontend/assets/images/interest-product/1.png') }}"
                                                alt="">
                                        @endif
                                    </div>
                                    <div class="text w-50">
                                        <h2><a
                                                href="{{ route('single-product', ['product' => $product->slug]) }}">{{ $product->name }}</a>
                                        </h2>
                                        <div class="rating-product">
                                            <i class="fi flaticon-star"></i>
                                            <i class="fi flaticon-star"></i>
                                            <i class="fi flaticon-star"></i>
                                            <i class="fi flaticon-star"></i>
                                            <i class="fi flaticon-star"></i>
                                            <span>({{ $product->reviews->count() }})</span>
                                        </div>
                                        <div class="price">
                                            <span class="present-price">
                                                {{ $symbol }}{{ $presentPrice }}
                                            </span>

                                            @if ($product->discount > 0)
                                                <del class="old-price">
                                                    {{ $symbol }}{{ $oldPrice }}
                                                </del>
                                            @endif
                                        </div>
                                        <div class="shop-btn">
                                            <a class="theme-btn-s2"
                                                href="{{ route('single-product', ['product' => $product->slug]) }}">{{ __('Shop Now') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- end of themart-special-product-section -->

    <!-- start of themart-trendingproduct-section -->
    <section class="themart-trendingproduct-section section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="wpo-section-title">
                        <h2>{{ __('Trending Products') }}</h2>
                    </div>
                </div>
            </div>
            <div class="trendin-slider owl-carousel">
                @php
                    // কারেন্সি ও এক্সচেঞ্জ রেট প্রসেসিং
                    $currency = session('currency', optional($setting)->currency_code ?? 'BDT');
                    $exchangeRate = 120; // 1 USD = 120 BDT (আপনার প্রয়োজন অনুযায়ী পরিবর্তন করতে পারেন)
                @endphp

                @foreach ($trendingProducts as $product)
                    @php
                        // প্রাইস ক্যালকুলেশন
                        $rawPresentPrice = $product->discount > 0 ? $product->discount_price : $product->sale_price;
                        $rawOldPrice = $product->sale_price;

                        // কারেন্সি অনুযায়ী সিম্বল ও প্রাইস কনভার্সন
                        if ($currency == 'USD') {
                            $symbol = '$';
                            $presentPrice = number_format($rawPresentPrice / $exchangeRate, 2);
                            $oldPrice = number_format($rawOldPrice / $exchangeRate, 2);
                        } else {
                            $symbol = optional($setting)->currency_symbol ?? '৳';
                            $presentPrice = number_format($rawPresentPrice, 2);
                            $oldPrice = number_format($rawOldPrice, 2);
                        }
                    @endphp

                    <div class="product-item">
                        <div class="image">

                            @if ($product->images->isNotEmpty())
                                <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}"
                                    style="width: 150px; height: 150px; object-fit: cover; margin: 0 auto;">
                            @else
                                <img src="{{ asset('frontend/assets/images/interest-product/1.png') }}"
                                    alt="{{ $product->name }}">
                            @endif

                            @if ($product->isNew())
                                <div class="tag new">{{ __('New') }}</div>
                            @endif
                        </div>
                        <div class="text">
                            <h2><a
                                    href="{{ route('single-product', ['product' => $product->slug]) }}">{{ $product->name }}</a>
                            </h2>
                            <div class="rating-product">
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <span>({{ $product->reviews->count() }})</span>
                            </div>
                            <div class="price">
                                <span class="present-price">
                                    {{ $symbol }}{{ $presentPrice }}
                                </span>

                                @if ($product->discount > 0)
                                    <del class="old-price">
                                        {{ $symbol }}{{ $oldPrice }}
                                    </del>
                                @endif
                            </div>
                            <div class="shop-btn">
                                <a class="theme-btn-s2"
                                    href="{{ route('single-product', ['product' => $product->slug]) }}">{{ __('Shop Now') }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- end of themart-trendingproduct-section -->

    <!-- start of themart-highlight-product-section -->
    <section class="themart-highlight-product-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="highlight-wrap">
                        <h2>{{ __('Top Selling') }}</h2>

                        @php
                            // কারেন্সি ও এক্সচেঞ্জ রেট প্রসেসিং
                            $currency = session('currency', optional($setting)->currency_code ?? 'BDT');
                            $exchangeRate = 120; // 1 USD = 120 BDT (আপনার প্রয়োজন অনুযায়ী পরিবর্তন করতে পারেন)
                        @endphp

                        @foreach ($topSellingProducts as $product)
                            @php
                                // প্রাইস ক্যালকুলেশন
                                $rawPresentPrice =
                                    $product->discount > 0 ? $product->discount_price : $product->sale_price;
                                $rawOldPrice = $product->sale_price;

                                // কারেন্সি অনুযায়ী সিম্বল ও প্রাইস কনভার্সন
                                if ($currency == 'USD') {
                                    $symbol = '$';
                                    $presentPrice = number_format($rawPresentPrice / $exchangeRate, 2);
                                    $oldPrice = number_format($rawOldPrice / $exchangeRate, 2);
                                } else {
                                    $symbol = optional($setting)->currency_symbol ?? '৳';
                                    $presentPrice = number_format($rawPresentPrice, 2);
                                    $oldPrice = number_format($rawOldPrice, 2);
                                }
                            @endphp

                            <div class="product-card">
                                <div class="card-image" style="width: 140px; height: 110px;">
                                    <div class="image">

                                        @if ($product->images->isNotEmpty())
                                            <img src="{{ asset('storage/' . $product->thumbnail) }}"
                                                alt="{{ $product->name }}" class=""
                                                style="margin: 0 auto; width: 100px; height: 100px;">
                                        @else
                                            <img src="{{ asset('frontend/assets/images/interest-product/1.png') }}"
                                                alt="{{ $product->name }}">
                                        @endif
                                    </div>
                                </div>
                                <div class="content">
                                    <h3><a href="{{ route('single-product', ['product' => $product->slug]) }}">{{ $product->name }}
                                        </a></h3>
                                    <div class="rating-product">
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <span>({{ $product->reviews->count() }})</span>
                                    </div>
                                    <div class="price d-flex gap-1">
                                        <span class="present-price">
                                            {{ $symbol }}{{ $presentPrice }}
                                        </span>

                                        @if ($product->discount > 0)
                                            <del class="old-price">
                                                {{ $symbol }}{{ $oldPrice }}
                                            </del>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="highlight-wrap">
                        <h2>{{ __('Recently Added') }}</h2>

                        @php
                            // কারেন্সি ও এক্সচেঞ্জ রেট প্রসেসিং
                            $currency = session('currency', optional($setting)->currency_code ?? 'BDT');
                            $exchangeRate = 120; // 1 USD = 120 BDT (আপনার প্রয়োজন অনুযায়ী পরিবর্তন করতে পারেন)
                        @endphp

                        @foreach ($recentlyAddedProducts as $product)
                            @php
                                // প্রাইস ক্যালকুলেশন
                                $rawPresentPrice =
                                    $product->discount > 0 ? $product->discount_price : $product->sale_price;
                                $rawOldPrice = $product->sale_price;

                                // কারেন্সি অনুযায়ী সিম্বল ও প্রাইস কনভার্সন
                                if ($currency == 'USD') {
                                    $symbol = '$';
                                    $presentPrice = number_format($rawPresentPrice / $exchangeRate, 2);
                                    $oldPrice = number_format($rawOldPrice / $exchangeRate, 2);
                                } else {
                                    $symbol = optional($setting)->currency_symbol ?? '৳';
                                    $presentPrice = number_format($rawPresentPrice, 2);
                                    $oldPrice = number_format($rawOldPrice, 2);
                                }
                            @endphp

                            <div class="product-card">
                                <div class="card-image" style="width: 140px; height: 110px;">
                                    <div class="image">

                                        @if ($product->images->isNotEmpty())
                                            <img src="{{ asset('storage/' . $product->thumbnail) }}"
                                                alt="{{ $product->name }}" class=""
                                                style="margin: 0 auto; width: 100px; height: 100px;">
                                        @else
                                            <img src="{{ asset('frontend/assets/images/interest-product/1.png') }}"
                                                alt="{{ $product->name }}">
                                        @endif
                                    </div>
                                </div>
                                <div class="content">
                                    <h3><a
                                            href="{{ route('single-product', ['product' => $product->slug]) }}">{{ $product->name }}</a>
                                    </h3>
                                    <div class="rating-product">
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <span>({{ $product->reviews->count() }})</span>
                                    </div>
                                    <div class="price">
                                        <span class="present-price">{{ $symbol }}{{ $presentPrice }}</span>
                                        <del class="old-price">{{ $symbol }}{{ $oldPrice }}</del>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="highlight-wrap">
                        <h2>{{ __('Top Rated') }}</h2>

                        @php
                            // কারেন্সি ও এক্সচেঞ্জ রেট প্রসেসিং
                            $currency = session('currency', optional($setting)->currency_code ?? 'BDT');
                            $exchangeRate = 120; // 1 USD = 120 BDT (আপনার প্রয়োজন অনুযায়ী পরিবর্তন করতে পারেন)
                        @endphp

                        @foreach ($topRatedProducts as $product)
                            @php
                                // প্রাইস ক্যালকুলেশন
                                $rawPresentPrice =
                                    $product->discount > 0 ? $product->discount_price : $product->sale_price;
                                $rawOldPrice = $product->sale_price;

                                // কারেন্সি অনুযায়ী সিম্বল ও প্রাইস কনভার্সন
                                if ($currency == 'USD') {
                                    $symbol = '$';
                                    $presentPrice = number_format($rawPresentPrice / $exchangeRate, 2);
                                    $oldPrice = number_format($rawOldPrice / $exchangeRate, 2);
                                } else {
                                    $symbol = optional($setting)->currency_symbol ?? '৳';
                                    $presentPrice = number_format($rawPresentPrice, 2);
                                    $oldPrice = number_format($rawOldPrice, 2);
                                }
                            @endphp

                            <div class="product-card">
                                <div class="card-image" style="width: 140px; height: 110px;">
                                    <div class="image">

                                        @if ($product->images->isNotEmpty())
                                            <img src="{{ asset('storage/' . $product->thumbnail) }}"
                                                alt="{{ $product->name }}" class=""
                                                style="margin: 0 auto; width: 100px; height: 100px;">
                                        @else
                                            <img src="{{ asset('frontend/assets/images/interest-product/1.png') }}"
                                                alt="{{ $product->name }}">
                                        @endif
                                    </div>
                                </div>
                                <div class="content">
                                    <h3><a
                                            href="{{ route('single-product', ['product' => $product->slug]) }}">{{ $product->name }}</a>
                                    </h3>
                                    <div class="rating-product">
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <span>({{ $product->reviews->count() }})</span>
                                    </div>
                                    <div class="price d-flex gap-1">
                                        <span class="present-price">
                                            {{ $symbol }}{{ $presentPrice }}
                                        </span>

                                        @if ($product->discount > 0)
                                            <del class="old-price">
                                                {{ $symbol }}{{ $oldPrice }}
                                            </del>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end of themart-highlight-product-section -->

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
                                    <input type="email" name="email" class="form-control"
                                        placeholder="Your Email..." value="{{ old('email') }}" required>
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
@endsection
