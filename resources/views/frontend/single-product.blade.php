@extends('frontend.layouts.app')

@section('content')
    <!-- start wpo-page-title -->
    <section class="wpo-page-title">
        <h2 class="d-none">Hide</h2>
        <div class="container">
            <div class="row">
                <div class="col col-xs-12">
                    <div class="wpo-breadcumb-wrap">
                        <ol class="wpo-breadcumb-wrap">
                            <li><a href="{{ route('home.index') }}">Home</a></li>
                            <li><a href="{{ route('home.shop') }}">Product</a></li>
                            <li>Product Single</li>
                        </ol>
                    </div>
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>
    <!-- end page-title -->

    <!-- product-single-section  start-->
    <div class="product-single-section section-padding">
        <div class="container">
            <div class="product-details">
                <div class="row align-items-center">
                    <div class="col-lg-5">
                        <div class="product-single-img">

                            {{-- ১. বড় বা মেইন স্লাইডার --}}
                            <div class="product-active owl-carousel">

                                {{-- কভার / থাম্বনেইল ইমেজ (১ম স্লাইড) --}}
                                @if ($product->thumbnail)
                                    <div class="item">
                                        <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}"
                                            style="width: 100%; height: 400px; object-fit: cover; margin: 0 auto;">
                                    </div>
                                @endif

                                {{-- গ্যালারি ইমেজসমূহ --}}
                                @forelse ($product->images as $image)
                                    <div class="item">
                                        <img src="{{ asset('storage/' . $image->image) }}" alt="{{ $product->name }}"
                                            style="width: 100%; height: 400px; object-fit: cover; margin: 0 auto;">
                                    </div>
                                @empty
                                    {{-- কভার ইমেজও যদি না থাকে তবে ডিফল্ট নো-ইমেজ দেখাবে --}}
                                    @if (!$product->thumbnail)
                                        <div class="item">
                                            <img src="{{ asset('frontend/assets/images/no-image.jpg') }}"
                                                alt="{{ $product->name }}"
                                                style="width: 100%; height: 400px; object-fit: cover;">
                                        </div>
                                    @endif
                                @endforelse

                            </div>

                            {{-- ২. থাম্বনেইল গ্যালারি স্লাইডার --}}
                            <div class="product-thumbnil-active owl-carousel">

                                {{-- কভার / থাম্বনেইল ইমেজ (১ম থাম্বনেইল) --}}
                                @if ($product->thumbnail)
                                    <div class="item">
                                        <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}"
                                            style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;">
                                    </div>
                                @endif

                                {{-- গ্যালারি থাম্বনেইলসমূহ --}}
                                @forelse ($product->images as $image)
                                    <div class="item">
                                        <img src="{{ asset('storage/' . $image->image) }}" alt="{{ $product->name }}"
                                            style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;">
                                    </div>
                                @empty
                                    @if (!$product->thumbnail)
                                        <div class="item">
                                            <img src="{{ asset('frontend/assets/images/no-image.jpg') }}"
                                                alt="{{ $product->name }}"
                                                style="width: 80px; height: 80px; object-fit: cover;">
                                        </div>
                                    @endif
                                @endforelse

                            </div>

                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="product-single-content">
                            <h2>{{ $product->name }}</h2>
                            <div class="price">
                                <span class="present-price">${{ $product->discount_price }}</span>
                                <del class="old-price">${{ $product->sale_price }}</del>
                            </div>
                            <div class="rating-product">
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <span>({{ $product->reviews->count() }})</span>
                            </div>
                            <p>
                                {{ $product->short_description }}
                            </p>
                            <div class="product-filter-item color">
                                <div class="color-name">
                                    <span>Color :</span>

                                    <ul>
                                        @foreach ($product->colors as $color)
                                            <li class="color{{ $color->id }}">
                                                <input id="color{{ $color->id }}" type="radio" name="color"
                                                    value="{{ $color->id }}">

                                                <label for="color{{ $color->id }}" title="{{ $color->name }}"
                                                    style="
                            width: 25px;
                            height: 25px;
                            border-radius: 50%;
                            background-color: {{ $color->code }};
                            display: inline-block;
                            border: 1px solid #ddd;
                            cursor: pointer;
                        "></label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="product-filter-item color filter-size">
                                <div class="color-name">
                                    <span>Sizes:</span>
                                    <ul>
                                        @foreach ($product->sizes as $size)
                                            <li class="color{{ $size->id }}">
                                                <input id="sz{{ $size->id }}" type="radio" name="size"
                                                    value="{{ $size->id }}">
                                                <label for="sz{{ $size->id }}">{{ $size->name }}</label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="pro-single-btn">
                                <div class="quantity cart-plus-minus">
                                    <input class="text-value" type="text" value="1">
                                </div>
                                {{-- <a href="{{ route('cart.index') }}" class="theme-btn-s2">Add to cart</a> --}}
                                <form action="{{ route('cart.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="theme-btn-s2 border-0">Add to Cart</button>
                                </form>
                                <a href="#" class="wl-btn add-to-wishlist" data-product-id="{{ $product->id }}"><i
                                        class="fi flaticon-heart"></i></a>

                                <!-- Compare Button (নতুন যোগ করা হয়েছে) -->
                                <a href="{{ route('compare.add', $product->id) }}" class="wl-btn add-to-compare"
                                    data-product-id="{{ $product->id }}" title="Compare">
                                    <i class="fi flaticon-right-and-left"></i>
                                </a>
                            </div>
                            <ul class="important-text">
                                <li><span>SKU:</span>{{ $product->sku }}</li>
                                <li><span>Categories:</span>{{ $product->category->name }}</li>
                                <li><span>Tags:</span>{{ $product->tags->pluck('name')->implode(', ') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product-tab-area">
                <ul class="nav nav-mb-3 main-tab" id="tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="descripton-tab" data-bs-toggle="pill"
                            data-bs-target="#descripton" type="button" role="tab" aria-controls="descripton"
                            aria-selected="true">Description</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="Ratings-tab" data-bs-toggle="pill" data-bs-target="#Ratings"
                            type="button" role="tab" aria-controls="Ratings" aria-selected="false">Reviews
                            ({{ $product->reviews->count() }})</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="Information-tab" data-bs-toggle="pill"
                            data-bs-target="#Information" type="button" role="tab" aria-controls="Information"
                            aria-selected="false">Additional
                            info</button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="descripton" role="tabpanel"
                        aria-labelledby="descripton-tab">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="Descriptions-item">
                                        <p>{{ $product->description }}
                                            egestas egestas. A lectus proin suscipit viverra venenatis eget eget
                                            libero scelerisque. Lacinia parturient id eu vel justo cursus eu. Libero
                                            cursus nisl sollicitudin commodo magnis quam ultrices morbi. Et vitae
                                            eget bibendum quam sed velit. Eget ornare urna nibh ullamcorper sed.
                                            Habitant adipiscing dignissim aliquet laoreet ultrices etiam nulla sed
                                            ut. Lectus ut vitae dignissim in cum id id velit egestas. Magna vel leo
                                            hac massa at.

                                            <br> <br> Urna fermentum id eget turpis eleifend id vitae. Mauris
                                            malesuada ac arcu adipiscing etiam velit at tortor cras. Lacus eget
                                            mollis gravida vulputate sed habitasse enim tempor ullamcorper. Dictum
                                            enim quis morbi tincidunt. Nibh congue massa et arcu viverra lobortis.
                                            Lectus ullamcorper id ut dictumst odio elit. Tristique dapibus diam
                                            velit pharetra quisque odio.
                                        </p>
                                        {{-- <div class="Description-table">
                                            <ul>
                                                <li>While thus cackled sheepishly rigid after due one assenting</li>
                                                <li>Et vitae eget bibendum quam sed velit. Eget ornare urna nibh ullamcorper
                                                    sed.</li>
                                                <li>Habitant adipiscing dignissim aliquet laoreet ultrices etiam nulla sed
                                                    ut.</li>
                                                <li>Lacinia parturient id eu vel justo cursus eu.</li>
                                                <li>Mauris malesuada ac arcu adipiscing etiam velit at tortor cras.</li>

                                            </ul>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="Ratings" role="tabpanel" aria-labelledby="Ratings-tab">
                        <div class="container">
                            <div class="rating-section">
                                <div class="row">
                                    <div class="col-lg-12 col-12">
                                        <div class="comments-area">
                                            <div class="comments-section">
                                                <h3 class="comments-title">
                                                    {{ $product->reviews->count() }} reviews for {{ $product->name }}
                                                </h3>

                                                <ol class="comments" style="list-style: none;">
                                                    @forelse ($product->reviews as $review)
                                                        <li class="comment depth-1">
                                                            <div class="comment-main-area d-flex gap-3">
                                                                <!-- User Profile Image Area -->
                                                                <div class="comment-image">
                                                                    @if ($review->user && $review->user->image)
                                                                        <img src="{{ asset('uploads/profile/' . $review->user->image) }}"
                                                                            alt="{{ $review->user->name }}"
                                                                            style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover;">
                                                                    @else
                                                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($review->user->name ?? 'User') }}&background=0D6EFD&color=fff"
                                                                            alt="Default Avatar"
                                                                            style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover;">
                                                                    @endif
                                                                </div>

                                                                <div class="comment-wrapper">
                                                                    <div class="comments-meta">
                                                                        <h4>{{ $review->user->name ?? 'Anonymous' }}</h4>
                                                                        <span class="comments-date">
                                                                            {{ $review->created_at->format('F d, Y \a\t g:i a') }}
                                                                        </span>

                                                                        <!-- Dynamic Star Rating -->
                                                                        <div class="rating-product">
                                                                            @for ($i = 1; $i <= 5; $i++)
                                                                                @if ($i <= $review->rating)
                                                                                    <i class="fi flaticon-star"></i>
                                                                                @else
                                                                                    <i class="fi flaticon-star-1"
                                                                                        style="color: #ccc;"></i>
                                                                                @endif
                                                                            @endfor
                                                                        </div>
                                                                    </div>

                                                                    <div class="comment-area">
                                                                        <p>{{ $review->comment }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @empty
                                                        <p class="py-3 text-muted">No reviews yet. Be the first to review
                                                            this product!</p>
                                                    @endforelse
                                                </ol>
                                            </div> <!-- end comments-section -->

                                            <!-- Add Review Form -->
                                            <div class="comment-respond mt-5">
                                                <h3 class="comment-reply-title">Add a review</h3>

                                                <!-- Flash Notification Messages -->
                                                @if (session('success'))
                                                    <div class="alert alert-success alert-dismissible fade show mt-3"
                                                        role="alert">
                                                        {{ session('success') }}
                                                    </div>
                                                @endif

                                                @if (session('error'))
                                                    <div class="alert alert-danger alert-dismissible fade show mt-3"
                                                        role="alert">
                                                        {{ session('error') }}
                                                    </div>
                                                @endif

                                                @auth
                                                    <!-- Logged-in User Profile Header in Form -->
                                                    <div class="d-flex align-items-center gap-2 mt-3 mb-2">
                                                        <img src="{{ asset('uploads/profile/' . auth()->user()->image) }}"
                                                            alt="{{ auth()->user()->name }}"
                                                            style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;"
                                                            onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}';">
                                                        <span class="fw-bold">{{ auth()->user()->name }}</span>
                                                    </div>

                                                    <form action="{{ route('frontend.reviews.store', $product->id) }}"
                                                        method="POST" class="comment-form">
                                                        @csrf

                                                        <div class="form-inputs row mb-3">
                                                            <div class="col-md-12">
                                                                <label class="form-label d-block fw-bold">Your Rating *</label>
                                                                <select name="rating"
                                                                    class="form-control @error('rating') is-invalid @enderror"
                                                                    required style="max-width: 220px;">
                                                                    <option value="" disabled selected>Select Rating
                                                                    </option>
                                                                    <option value="5"
                                                                        {{ old('rating') == 5 ? 'selected' : '' }}>5 Stars
                                                                        (Excellent)
                                                                    </option>
                                                                    <option value="4"
                                                                        {{ old('rating') == 4 ? 'selected' : '' }}>4 Stars
                                                                        (Good)</option>
                                                                    <option value="3"
                                                                        {{ old('rating') == 3 ? 'selected' : '' }}>3 Stars
                                                                        (Average)</option>
                                                                    <option value="2"
                                                                        {{ old('rating') == 2 ? 'selected' : '' }}>2 Stars (Not
                                                                        Bad)</option>
                                                                    <option value="1"
                                                                        {{ old('rating') == 1 ? 'selected' : '' }}>1 Star (Very
                                                                        Poor)</option>
                                                                </select>
                                                                @error('rating')
                                                                    <span class="text-danger small">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="form-textarea mb-3">
                                                            <label for="comment" class="form-label fw-bold">Your
                                                                Review</label>
                                                            <textarea id="comment" name="comment" class="form-control @error('comment') is-invalid @enderror" rows="4"
                                                                placeholder="Write your review here...">{{ old('comment') }}</textarea>
                                                            @error('comment')
                                                                <span class="text-danger small">{{ $message }}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-submit">
                                                            <button type="submit" class="theme-btn-s2 border-0">Submit
                                                                Review</button>
                                                        </div>
                                                    </form>
                                                @else
                                                    <div class="alert alert-warning mt-3">
                                                        Please <a href="{{ route('login') }}"
                                                            class="fw-bold text-decoration-underline">login</a> to write a
                                                        review.
                                                    </div>
                                                @endauth
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="Information" role="tabpanel" aria-labelledby="Information-tab">
                        <div class="container">
                            <div class="Additional-wrap">
                                <div class="row">
                                    <div class="col-12">
                                        <table class="table table-striped table-bordered responsive">
                                            <tbody>
                                                @php $hasData = false; @endphp

                                                {{-- Category --}}
                                                @if (!empty($product->category->name))
                                                    @php $hasData = true; @endphp
                                                    <tr>
                                                        <th style="width: 30%;">Category</th>
                                                        <td>{{ $product->category->name }}</td>
                                                    </tr>
                                                @endif

                                                {{-- Sub Category --}}
                                                @if (!empty($product->subCategory->name))
                                                    @php $hasData = true; @endphp
                                                    <tr>
                                                        <th>Sub Category</th>
                                                        <td>{{ $product->subCategory->name }}</td>
                                                    </tr>
                                                @endif

                                                {{-- Brand --}}
                                                @if (!empty($product->brand->name))
                                                    @php $hasData = true; @endphp
                                                    <tr>
                                                        <th>Brand</th>
                                                        <td>{{ $product->brand->name }}</td>
                                                    </tr>
                                                @endif

                                                {{-- SKU --}}
                                                @if (!empty($product->sku))
                                                    @php $hasData = true; @endphp
                                                    <tr>
                                                        <th>SKU</th>
                                                        <td>{{ $product->sku }}</td>
                                                    </tr>
                                                @endif

                                                {{-- Colors --}}
                                                @if ($product->colors && $product->colors->isNotEmpty())
                                                    @php $hasData = true; @endphp
                                                    <tr>
                                                        <th>Available Colors</th>
                                                        <td>{{ $product->colors->pluck('name')->implode(', ') }}</td>
                                                    </tr>
                                                @endif

                                                {{-- Sizes --}}
                                                @if ($product->sizes && $product->sizes->isNotEmpty())
                                                    @php $hasData = true; @endphp
                                                    <tr>
                                                        <th>Available Sizes</th>
                                                        <td>{{ $product->sizes->pluck('name')->implode(', ') }}</td>
                                                    </tr>
                                                @endif

                                                {{-- Stock Status --}}
                                                @if (isset($product->stock))
                                                    @php $hasData = true; @endphp
                                                    <tr>
                                                        <th>Stock Availability</th>
                                                        <td>
                                                            @if ($product->stock > 0)
                                                                <span class="badge bg-success">In Stock
                                                                    ({{ $product->stock }})</span>
                                                            @else
                                                                <span class="badge bg-danger">Out of Stock</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif

                                                {{-- Fallback message if no data exists --}}
                                                @if (!$hasData)
                                                    <tr>
                                                        <td colspan="2" class="text-center text-muted py-3">
                                                            No additional information available for this product.
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="related-product">
        </div>
    </div>
    <!-- product-single-section  end-->
@endsection

@push('style')
    <style>
        .product-single-section .product-tab-area .rating-section .comments-area .comment-main-area {
            padding-left: 60px;
        }
    </style>
@endpush
