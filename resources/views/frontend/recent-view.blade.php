@extends('frontend.layouts.app')

@section('content')
    <section class="wpo-page-title">
        <h2 class="d-none">Hide</h2>
        <div class="container">
            <div class="row">
                <div class="col col-xs-12">
                    <div class="wpo-breadcumb-wrap">
                        <ol class="wpo-breadcumb-wrap">
                            <li><a href="{{ route('home.index') }}">Home</a></li>
                            <li>Recently Viewed</li>
                        </ol>
                    </div>
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>
    <!-- end page-title -->

    <!-- start of themart-interestproduct-section -->
    <section class="themart-interestproduct-section section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="wpo-section-title">
                        <h2>Recently Viewed Product</h2>
                    </div>
                </div>
            </div>
            <div class="product-wrap">
                <div class="row">

                    @forelse ($recentProducts as $product)
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                            <div class="product-item">
                                <div class="image">
                                    @if ($product->images && $product->images->isNotEmpty())
                                        <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}"
                                            style="width: 150px; height: 150px;">
                                    @else
                                        <img src="{{ asset('frontend/assets/images/interest-product/1.png') }}"
                                            alt="{{ $product->name }}">
                                    @endif

                                    @if (method_exists($product, 'isNew') && $product->isNew())
                                        <div class="tag new">New</div>
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
                                        <span>{{ $product->reviews ? $product->reviews->count() : 0 }}</span>
                                    </div>
                                    <div class="price">
                                        <span class="present-price">
                                            ${{ number_format($product->discount && $product->discount > 0 ? $product->discount_price : $product->sale_price, 2) }}
                                        </span>

                                        @if ($product->discount && $product->discount > 0)
                                            <del class="old-price">
                                                ${{ number_format($product->sale_price, 2) }}
                                            </del>
                                        @endif
                                    </div>
                                    <div class="shop-btn">
                                        <a class="theme-btn-s2"
                                            href="{{ route('single-product', ['product' => $product->slug]) }}">Shop
                                            Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <p class="text-muted fs-5">You haven't viewed any products recently!</p>
                        </div>
                    @endforelse

                    {{-- Load More Button: পরবর্তী পেজ থাকলে বাটন দেখাবে --}}
                    @if ($recentProducts instanceof \Illuminate\Pagination\LengthAwarePaginator && $recentProducts->hasMorePages())
                        <div class="col-12 text-center mt-4">
                            <div class="more-btn">
                                <a class="theme-btn-s2" href="{{ $recentProducts->nextPageUrl() }}">Load More</a>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </section>
    <!-- end of themart-interestproduct-section -->
@endsection
