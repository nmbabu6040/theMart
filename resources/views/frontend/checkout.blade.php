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
                            <li>
                                <a href="{{ route('home.index') }}">Home</a>
                            </li>

                            <li>
                                <a href="{{ route('cart.index') }}">Cart</a>
                            </li>

                            <li>Checkout</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end page-title -->


    <!-- wpo-checkout-area start -->
    <div class="wpo-checkout-area section-padding">

        <div class="container">

            <!-- Page Title -->
            <div class="row">
                <div class="col-12">
                    <div class="single-page-title">
                        <h2>Your Checkout</h2>

                        <p>
                            There are {{ $cartItems->count() }}
                            {{ $cartItems->count() == 1 ? 'product' : 'products' }}
                            in this list
                        </p>
                    </div>
                </div>
            </div>


            <!-- Checkout Form -->
            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf

                <div class="checkout-wrap">

                    <div class="row">

                        <!-- =========================
                                             LEFT SIDE
                                        ========================== -->
                        <div class="col-lg-8 col-12">

                            <div class="caupon-wrap s3">

                                <div class="biling-item">

                                    <!-- =========================
                                                         BILLING ADDRESS
                                                    ========================== -->

                                    <div class="coupon coupon-3">
                                        <h2>Billing Address</h2>
                                    </div>

                                    <div class="billing-adress">

                                        <div class="contact-form form-style">

                                            <div class="row">

                                                <!-- First Name -->
                                                <div class="col-lg-6 col-md-12 col-12">
                                                    <input type="text" placeholder="First Name*" name="billing_fname"
                                                        value="{{ old('billing_fname', auth()->user()->name ?? '') }}"
                                                        required>

                                                    @error('billing_fname')
                                                        <small class="text-danger">
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </div>


                                                <!-- Last Name -->
                                                <div class="col-lg-6 col-md-12 col-12">
                                                    <input type="text" placeholder="Last Name*" name="billing_lname"
                                                        value="{{ old('billing_lname') }}" required>

                                                    @error('billing_lname')
                                                        <small class="text-danger">
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </div>


                                                <!-- Country -->
                                                <div class="col-lg-6 col-md-12 col-12">

                                                    <select name="billing_country_id"
                                                        class="form-control @error('billing_country_id') is-invalid @enderror"
                                                        required>
                                                        <option value="">Select Country</option>

                                                        @foreach ($countries as $country)
                                                            <option value="{{ $country->id }}"
                                                                @selected(old('billing_country_id') == $country->id)>
                                                                {{ $country->name }}
                                                            </option>
                                                        @endforeach

                                                    </select>

                                                    @error('billing_country_id')
                                                        <small class="text-danger">
                                                            {{ $message }}
                                                        </small>
                                                    @enderror

                                                </div>


                                                <!-- City -->
                                                <div class="col-lg-6 col-md-12 col-12">
                                                    <input type="text" placeholder="City / Town*" name="billing_city"
                                                        value="{{ old('billing_city') }}" required>

                                                    @error('billing_city')
                                                        <small class="text-danger">
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </div>


                                                <!-- Postcode -->
                                                <div class="col-lg-6 col-md-12 col-12">
                                                    <input type="text" placeholder="Postcode / ZIP*"
                                                        name="billing_postcode" value="{{ old('billing_postcode') }}"
                                                        required>

                                                    @error('billing_postcode')
                                                        <small class="text-danger">
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </div>


                                                <!-- Company -->
                                                <div class="col-lg-6 col-md-12 col-12">
                                                    <input type="text" placeholder="Company Name" name="billing_company"
                                                        value="{{ old('billing_company') }}">

                                                    @error('billing_company')
                                                        <small class="text-danger">
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </div>


                                                <!-- Email -->
                                                <div class="col-lg-6 col-md-12 col-12">
                                                    <input type="email" placeholder="Email Address*" name="billing_email"
                                                        value="{{ old('billing_email', auth()->user()->email ?? '') }}"
                                                        required>

                                                    @error('billing_email')
                                                        <small class="text-danger">
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </div>


                                                <!-- Phone -->
                                                <div class="col-lg-6 col-md-12 col-12">
                                                    <input type="text" placeholder="Phone*" name="billing_phone"
                                                        value="{{ old('billing_phone') }}" required>

                                                    @error('billing_phone')
                                                        <small class="text-danger">
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </div>


                                                <!-- Address -->
                                                <div class="col-lg-12 col-md-12 col-12">
                                                    <input type="text" placeholder="Address*" name="billing_address"
                                                        value="{{ old('billing_address') }}" required>

                                                    @error('billing_address')
                                                        <small class="text-danger">
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </div>


                                                <!-- Order Notes -->
                                                <div class="col-lg-12 col-md-12 col-12">

                                                    <div class="note-area">

                                                        <textarea name="order_notes" placeholder="Additional Information">{{ old('order_notes') }}</textarea>

                                                        @error('order_notes')
                                                            <small class="text-danger">
                                                                {{ $message }}
                                                            </small>
                                                        @enderror

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>


                                    <!-- =========================
                                                         SHIPPING ADDRESS
                                                    ========================== -->

                                    <div class="biling-item-3">

                                        <input id="toggle4" type="checkbox" name="ship_to_different" value="1"
                                            {{ old('ship_to_different') ? 'checked' : '' }}>

                                        <label class="fontsize" for="toggle4">
                                            Ship to a Different Address?
                                        </label>


                                        <div class="billing-adress" id="open4"
                                            style="{{ old('ship_to_different') ? '' : 'display:none;' }}">

                                            <div class="contact-form form-style">

                                                <div class="row">

                                                    <!-- Shipping First Name -->
                                                    <div class="col-lg-6 col-md-12 col-12">
                                                        <input type="text" placeholder="First Name*"
                                                            name="shipping_fname" value="{{ old('shipping_fname') }}">

                                                        @error('shipping_fname')
                                                            <small class="text-danger">
                                                                {{ $message }}
                                                            </small>
                                                        @enderror
                                                    </div>


                                                    <!-- Shipping Last Name -->
                                                    <div class="col-lg-6 col-md-12 col-12">
                                                        <input type="text" placeholder="Last Name*"
                                                            name="shipping_lname" value="{{ old('shipping_lname') }}">

                                                        @error('shipping_lname')
                                                            <small class="text-danger">
                                                                {{ $message }}
                                                            </small>
                                                        @enderror
                                                    </div>


                                                    <!-- Shipping Country -->
                                                    <div class="col-lg-6 col-md-12 col-12">

                                                        <select name="shipping_country_id" class="form-control">
                                                            <option value="" disabled
                                                                {{ old('shipping_country_id') ? '' : 'selected' }}>
                                                                Country*
                                                            </option>

                                                            @foreach ($countries as $country)
                                                                <option value="{{ $country->id }}"
                                                                    @selected(old('shipping_country_id') == $country->id)>
                                                                    {{ $country->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                        @error('shipping_country_id')
                                                            <small class="text-danger">
                                                                {{ $message }}
                                                            </small>
                                                        @enderror

                                                    </div>


                                                    <!-- Shipping City -->
                                                    <div class="col-lg-6 col-md-12 col-12">
                                                        <input type="text" placeholder="City / Town*"
                                                            name="shipping_city" value="{{ old('shipping_city') }}">

                                                        @error('shipping_city')
                                                            <small class="text-danger">
                                                                {{ $message }}
                                                            </small>
                                                        @enderror
                                                    </div>


                                                    <!-- Shipping Postcode -->
                                                    <div class="col-lg-6 col-md-12 col-12">
                                                        <input type="text" placeholder="Postcode / ZIP*"
                                                            name="shipping_postcode"
                                                            value="{{ old('shipping_postcode') }}">

                                                        @error('shipping_postcode')
                                                            <small class="text-danger">
                                                                {{ $message }}
                                                            </small>
                                                        @enderror
                                                    </div>


                                                    <!-- Shipping Company -->
                                                    <div class="col-lg-6 col-md-12 col-12">
                                                        <input type="text" placeholder="Company Name"
                                                            name="shipping_company"
                                                            value="{{ old('shipping_company') }}">

                                                        @error('shipping_company')
                                                            <small class="text-danger">
                                                                {{ $message }}
                                                            </small>
                                                        @enderror
                                                    </div>


                                                    <!-- Shipping Email -->
                                                    <div class="col-lg-6 col-md-12 col-12">
                                                        <input type="email" placeholder="Email Address"
                                                            name="shipping_email" value="{{ old('shipping_email') }}">

                                                        @error('shipping_email')
                                                            <small class="text-danger">
                                                                {{ $message }}
                                                            </small>
                                                        @enderror
                                                    </div>


                                                    <!-- Shipping Phone -->
                                                    <div class="col-lg-6 col-md-12 col-12">
                                                        <input type="text" placeholder="Phone*" name="shipping_phone"
                                                            value="{{ old('shipping_phone') }}">

                                                        @error('shipping_phone')
                                                            <small class="text-danger">
                                                                {{ $message }}
                                                            </small>
                                                        @enderror
                                                    </div>


                                                    <!-- Shipping Address -->
                                                    <div class="col-lg-12 col-md-12 col-12">
                                                        <input type="text" placeholder="Address*"
                                                            name="shipping_address"
                                                            value="{{ old('shipping_address') }}">

                                                        @error('shipping_address')
                                                            <small class="text-danger">
                                                                {{ $message }}
                                                            </small>
                                                        @enderror
                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>


                        <!-- =========================
                                             RIGHT SIDE
                                        ========================== -->

                        <div class="col-lg-4 col-12">

                            <!-- =========================
                                                 YOUR ORDER
                                            ========================== -->

                            <div class="cout-order-area">

                                <h3>Your Order</h3>

                                <div class="oreder-item">

                                    <div class="title">
                                        <h2>
                                            Products
                                            <span>Subtotal</span>
                                        </h2>
                                    </div>


                                    @foreach ($cartItems as $item)
                                        @php
                                            $price = $item->product?->discount_price;

                                            if (!$price || $price <= 0) {
                                                $price = $item->product?->sale_price ?? 0;
                                            }

                                            $itemSubtotal = (float) $price * $item->quantity;
                                        @endphp


                                        <div class="oreder-product">

                                            <!-- Product Image -->
                                            <div class="images" style="width:80px;height:80px;">
                                                <span>
                                                    <img src="{{ asset('storage/' . $item->product->thumbnail) }}"
                                                        alt="{{ $item->product->name }}"
                                                        style="width:80px;height:80px;object-fit:cover;">
                                                </span>
                                            </div>


                                            <!-- Product Info -->
                                            <div class="product">

                                                <ul>

                                                    <li class="first-cart">

                                                        <span>
                                                            {{ $item->product?->name }}
                                                            × {{ $item->quantity }}
                                                        </span>

                                                        <span>
                                                            ${{ number_format($itemSubtotal, 2) }}
                                                        </span>

                                                    </li>


                                                    <!-- Rating -->
                                                    <li>

                                                        <div class="rating-product">

                                                            @php
                                                                $rating = $item->product?->reviews?->avg('rating') ?? 0;
                                                                $reviewCount = $item->product?->reviews?->count() ?? 0;
                                                            @endphp

                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <i class="fi flaticon-star"
                                                                    style="{{ $i <= round($rating) ? '' : 'opacity:.3;' }}"></i>
                                                            @endfor

                                                            <span>
                                                                {{ $reviewCount }}
                                                            </span>

                                                        </div>

                                                    </li>

                                                </ul>

                                            </div>

                                        </div>
                                    @endforeach


                                    <!-- =========================
                                                         SUBTOTAL
                                                    ========================== -->

                                    <div class="mt-3">

                                        <div class="title border-0">

                                            <h2>
                                                Subtotal

                                                <span id="checkout-subtotal">
                                                    ${{ number_format($cartTotal, 2) }}
                                                </span>
                                            </h2>

                                        </div>

                                    </div>


                                    <!-- =========================
                                                         COUPON DISCOUNT
                                                    ========================== -->

                                    <div class="mt-2 mb-3">

                                        <div class="title border-0">

                                            <h2>
                                                Discount

                                                @if (!empty($coupon['code']))
                                                    <small>
                                                        ({{ $coupon['code'] }})
                                                    </small>
                                                @endif

                                                <span id="checkout-discount">
                                                    -${{ number_format($discount, 2) }}
                                                </span>

                                            </h2>

                                        </div>

                                    </div>


                                    <!-- =========================
                                                         DELIVERY
                                                    ========================== -->

                                    <div class="mt-3 mb-3">

                                        <div class="title border-0">
                                            <h2>Delivery Charge</h2>
                                        </div>


                                        <ul>

                                            <!-- Inside City -->
                                            <li class="free">

                                                <input id="inside-city" type="radio" name="delivery_charge"
                                                    value="{{ $insideCityCharge }}"
                                                    {{ old('delivery_charge', $insideCityCharge) == $insideCityCharge ? 'checked' : '' }}
                                                    required>

                                                <label for="inside-city">
                                                    Inside City:

                                                    <span>
                                                        ${{ number_format($insideCityCharge, 2) }}
                                                    </span>
                                                </label>

                                            </li>


                                            <!-- Outside City -->
                                            <li class="free">

                                                <input id="outside-city" type="radio" name="delivery_charge"
                                                    value="{{ $outsideCityCharge }}"
                                                    {{ old('delivery_charge') == $outsideCityCharge ? 'checked' : '' }}>

                                                <label for="outside-city">
                                                    Outside City:

                                                    <span>
                                                        ${{ number_format($outsideCityCharge, 2) }}
                                                    </span>
                                                </label>

                                            </li>

                                        </ul>

                                        @error('delivery_charge')
                                            <small class="text-danger">
                                                {{ $message }}
                                            </small>
                                        @enderror

                                    </div>


                                    <!-- =========================
                                                         GRAND TOTAL
                                                    ========================== -->

                                    <div class="title s2">

                                        <h2>
                                            Total

                                            <span id="checkout-total">
                                                ${{ number_format($grandTotal, 2) }}
                                            </span>
                                        </h2>

                                    </div>

                                </div>

                            </div>


                            <!-- =========================
                                                 PAYMENT
                                            ========================== -->

                            <div class="caupon-wrap s5">

                                <div class="payment-area">

                                    <div class="row">

                                        <div class="col-12">

                                            <div class="payment-option" id="open5">

                                                <h3>Payment</h3>


                                                <div class="payment-select">

                                                    <ul>

                                                        <!-- COD -->
                                                        <li>

                                                            <input id="cod" type="radio" name="payment_method"
                                                                value="cod"
                                                                {{ old('payment_method', 'cod') == 'cod' ? 'checked' : '' }}>

                                                            <label for="cod">
                                                                Cash on Delivery
                                                            </label>

                                                        </li>


                                                        <!-- SSLCOMMERZ -->
                                                        <li>

                                                            <input id="sslcommerz" type="radio" name="payment_method"
                                                                value="sslcommerz"
                                                                {{ old('payment_method', 'sslcommerz') == 'sslcommerz' ? 'checked' : '' }}>

                                                            <label for="sslcommerz">
                                                                Pay With SSLCOMMERZ
                                                            </label>

                                                        </li>


                                                        <!-- STRIPE -->
                                                        <li>

                                                            <input id="stripe" type="radio" name="payment_method"
                                                                value="stripe"
                                                                {{ old('payment_method') == 'stripe' ? 'checked' : '' }}>

                                                            <label for="stripe">
                                                                Pay With STRIPE
                                                            </label>

                                                        </li>

                                                    </ul>

                                                </div>


                                                <!-- Place Order -->
                                                <div id="open6" class="payment-name active">

                                                    <div class="contact-form form-style">

                                                        <div class="row">

                                                            <div class="col-lg-12 col-md-12 col-12">

                                                                <div class="submit-btn-area text-center">

                                                                    <button class="theme-btn" type="submit">
                                                                        Place Order
                                                                    </button>

                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>
    <!-- wpo-checkout-area end -->


    <!-- =========================
                         CHECKOUT JAVASCRIPT
                    ========================== -->

    @push('script')
        <script>
            $(document).ready(function() {

                /*
                |--------------------------------------------------------------------------
                | Shipping Address Toggle
                |--------------------------------------------------------------------------
                */

                $('#toggle4').on('change', function() {

                    if ($(this).is(':checked')) {
                        $('#open4').slideDown();
                    } else {
                        $('#open4').slideUp();
                    }

                });


                /*
                |--------------------------------------------------------------------------
                | Delivery Charge / Grand Total
                |--------------------------------------------------------------------------
                */

                const subtotal = Number(@json($cartTotal));
                const discount = Number(@json($discount));

                $('input[name="delivery_charge"]').on('change', function() {

                    const deliveryCharge = parseFloat($(this).val()) || 0;

                    const grandTotal = Math.max(
                        0,
                        subtotal - discount + deliveryCharge
                    );

                    $('#checkout-delivery').text(
                        '$' + deliveryCharge.toFixed(2)
                    );

                    $('#checkout-total').text(
                        '$' + grandTotal.toFixed(2)
                    );

                });

            });
        </script>
    @endpush
@endsection
