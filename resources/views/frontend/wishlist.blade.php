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
                            <li><a href="{{ route('home.shop') }}">Product Page</a></li>
                            <li>Wishlist</li>
                        </ol>
                    </div>
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>
    <!-- end page-title -->

    <!-- cart-area start -->
    <div class="cart-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="single-page-title">
                        <h2>Your Wishlist</h2>
                        <p>There are {{ count($wishlists) }} products in this list</p>
                    </div>
                </div>
            </div>
            <div class="cart-wrapper">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table cart-wrap align-middle">
                                <thead>
                                    <tr>
                                        <th class="images images-b">Product</th>
                                        <th class="price text-center">Price</th>
                                        <th class="stock text-center">Stock Status</th>
                                        <th class="action-btn text-center">Action</th>
                                        <th class="remove remove-b text-center">Remove</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($wishlists as $wishlist)
                                        <tr class="wishlist-item ">
                                            <td class="product-item-wish border-0">
                                                <!-- d-flex align-items-center দিয়ে চেকবক্স, ছবি ও নাম এক লাইনে আনা হয়েছে -->
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="check-box">
                                                        <input type="checkbox" class="myproject-checkbox">
                                                    </div>
                                                    <div class="images">
                                                        <img src="{{ asset('storage/' . $wishlist->product?->thumbnail) }}"
                                                            alt="{{ $wishlist->product?->name }}"
                                                            class="img-fluid bg-transparent"
                                                            style="width: 70px; height: 70px;">
                                                    </div>
                                                    <div class="product">
                                                        <ul class="list-unstyled mb-0">
                                                            <li class="first-cart fw-bold">{{ $wishlist->product?->name }}
                                                            </li>
                                                            <li>
                                                                <div class="rating-product text-warning">
                                                                    <i class="fi flaticon-star"></i>
                                                                    <i class="fi flaticon-star"></i>
                                                                    <i class="fi flaticon-star"></i>
                                                                    <i class="fi flaticon-star"></i>
                                                                    <i class="fi flaticon-star"></i>
                                                                    <span
                                                                        class="text-muted ms-1">({{ $wishlist->product?->reviews->count() }})</span>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="price text-center ">
                                                ${{ $wishlist->product?->discount > 0 ? $wishlist->product?->discount_price : $wishlist->product?->sale_price }}
                                            </td>
                                            <td class="stock text-center ">
                                                <span class="in-stock badge ">{{ $wishlist->product?->stock }}</span>
                                            </td>
                                            <td class="add-wish text-center">
                                                @if ($wishlist->product)
                                                    <a class="theme-btn-s2 btn btn-sm "
                                                        href="{{ route('single-product', ['product' => $wishlist->product->slug]) }}">
                                                        Shop Now
                                                    </a>
                                                @endif
                                            </td>
                                            <td class="action text-center ">
                                                <ul class="list-unstyled mb-0 d-inline-block">
                                                    <li class="w-btn">
                                                        <form action="{{ route('wishlist.destroy', $wishlist->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" onclick="return confirm('Remove item?')"
                                                                style="background:none; border:none; color:red; cursor:pointer; padding:0;">
                                                                <i class="ti-trash fs-4"></i>
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">No items in your
                                                wishlist.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- cart-area end -->
@endsection
