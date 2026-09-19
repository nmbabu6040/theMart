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
                            <li>Compare</li>
                        </ol>
                    </div>
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>
    <!-- end page-title -->

    <!-- start themart-compare-section  -->
    <section class="themart-compare-section">
        <h2 class="h-hidden">Compare List</h2>
        <div class="container">
            @if (isset($products) && $products->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>Product</td>
                                @foreach ($products as $product)
                                    <td class="text-title">{{ $product->name }}</td>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Images --}}
                            <tr>
                                <td>Images</td>
                                @foreach ($products as $product)
                                    <td>
                                        @if ($product->images->isNotEmpty())
                                            <img src="{{ asset('storage/' . $product->thumbnail) }}"
                                                alt="{{ $product->name }}" style="width: 100px; height: 100px;">
                                        @else
                                            <img src="{{ asset('frontend/assets/images/interest-product/1.png') }}"
                                                alt="{{ $product->name }}">
                                        @endif
                                    </td>
                                @endforeach
                            </tr>

                            {{-- Categories --}}
                            <tr>
                                <td>Categories</td>
                                @foreach ($products as $product)
                                    <td>{{ $product->category->name ?? 'N/A' }}</td>
                                @endforeach
                            </tr>

                            {{-- Price --}}
                            <tr>
                                <td>Price</td>
                                @foreach ($products as $product)
                                    <td>
                                        <span class="present-price">
                                            ${{ number_format($product->discount > 0 ? $product->discount_price : $product->sale_price, 2) }}
                                        </span>

                                        @if ($product->discount > 0)
                                            <del class="old-price">
                                                ${{ number_format($product->sale_price, 2) }}
                                            </del>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>

                            {{-- Color --}}
                            <tr>
                                <td>Color</td>
                                @foreach ($products as $product)
                                    <td>
                                        @if (isset($product->colors) && $product->colors->count() > 0)
                                            <div class="d-flex justify-content-center gap-2">
                                                @foreach ($product->colors as $color)
                                                    <span class="d-inline-block rounded-circle border shadow-sm"
                                                        style="background-color: {{ $color->code ?? $color->color_code }}; width: 20px; height: 20px;"
                                                        title="{{ $color->name ?? ($color->color_name ?? '') }}">
                                                    </span>
                                                @endforeach
                                            </div>
                                        @else
                                            @if ($product->color)
                                                <span class="d-inline-block rounded-circle border shadow-sm"
                                                    style="background-color: {{ $product->color }}; width: 20px; height: 20px;">
                                                </span>
                                            @else
                                                N/A
                                            @endif
                                        @endif
                                    </td>
                                @endforeach
                            </tr>

                            {{-- Size --}}
                            <tr>
                                <td>Size</td>
                                @foreach ($products as $product)
                                    <td>
                                        @if (isset($product->sizes) && $product->sizes->count() > 0)
                                            @foreach ($product->sizes as $size)
                                                <span
                                                    class="badge bg-secondary">{{ $size->name ?? $size->size_name }}</span>
                                            @endforeach
                                        @else
                                            {{ $product->size ?? 'N/A' }}
                                        @endif
                                    </td>
                                @endforeach
                            </tr>

                            {{-- Rating --}}
                            <tr>
                                <td>Rating</td>
                                @foreach ($products as $product)
                                    <td>
                                        <div class="rating-product">
                                            @php $rating = round($product->reviews_avg_rating ?? 5); @endphp
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i
                                                    class="fi flaticon-star {{ $i <= $rating ? 'text-warning' : 'text-muted' }}"></i>
                                            @endfor
                                            <span>({{ $product->reviews_count ?? 0 }})</span>
                                        </div>
                                    </td>
                                @endforeach
                            </tr>

                            {{-- Availability --}}
                            <tr>
                                <td>Availability</td>
                                @foreach ($products as $product)
                                    <td>
                                        @if (($product->quantity ?? 1) > 0)
                                            <span class="badge bg-success">In Stock</span>
                                        @else
                                            <span class="badge bg-danger">Out of Stock</span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>

                            {{-- Purchase --}}
                            <tr>
                                <td>Purchase</td>
                                @foreach ($products as $product)
                                    <td>
                                        <form action="{{ route('cart.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" value="1">

                                            <button type="submit" class="theme-btn-s2 btn-sm border-0">Add</button>
                                        </form>
                                    </td>
                                @endforeach
                            </tr>

                            {{-- Action (Remove Button) --}}
                            <tr>
                                <td>Action</td>
                                @foreach ($products as $product)
                                    <td>
                                        <a data-bs-toggle="tooltip" data-bs-html="true" title="Remove"
                                            href="{{ route('compare.remove', $product->id) }}" aria-label="Remove"
                                            onclick="return confirm('Are you sure you want to remove this item?')">
                                            <i class="fi flaticon-remove text-danger"></i>
                                        </a>
                                    </td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <h4>No products added to compare list!</h4>
                    <a href="{{ route('home.shop') }}" class="theme-btn-s2 mt-3">Go To Shop</a>
                </div>
            @endif
        </div>
    </section>
    <!-- end themart-compare-section  -->

    <!-- start of themart-cta-section -->
    <section class="themart-cta-section section-padding">
        <div class="container">
            <div class="cta-wrap">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-12">
                        <div class="cta-content">
                            <h2>Subscribe Our Newsletter & <br> Get 30% Discounts For Next Order</h2>
                            <form>
                                <div class="input-1">
                                    <input type="email" class="form-control" placeholder="Your Email..." required="">
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
