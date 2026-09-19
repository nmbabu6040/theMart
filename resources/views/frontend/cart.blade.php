@extends('frontend.layouts.app')

@section('content')
    <section class="wpo-page-title">
        <h2 class="d-none">Cart Page</h2>
        <div class="container">
            <div class="row">
                <div class="col col-xs-12">
                    <div class="wpo-breadcumb-wrap">
                        <ol class="wpo-breadcumb-wrap">
                            <li><a href="{{ route('home.index') }}">Home</a></li>
                            <li><a href="{{ route('home.shop') }}">Product Page</a></li>
                            <li>Cart</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="cart-area-s2 section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="single-page-title">
                        <h2>Your Cart</h2>
                        <p>There are {{ $carts->count() }} products in this list</p>
                    </div>
                </div>
            </div>
            <div class="cart-wrapper">
                <div class="row">
                    <div class="col-lg-8 col-12">
                        <div class="cart-item">
                            <div class="table-responsive">
                                <table class="table cart-wrap">
                                    <thead>
                                        <tr>
                                            <th class="images images-b">Product</th>
                                            <th class="ptice">Price</th>
                                            <th class="stock">Quantity</th>
                                            <th class="ptice total">Subtotal</th>
                                            <th class="remove remove-b">Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $totalSum = 0; @endphp

                                        @forelse ($carts as $cart)
                                            @php
                                                $price =
                                                    $cart->product?->discount > 0
                                                        ? $cart->product?->discount_price
                                                        : $cart->product?->sale_price;

                                                $subtotal = $price * $cart->quantity;
                                                $totalSum += $subtotal;
                                            @endphp

                                            <tr class="wishlist-item cart-row" data-id="{{ $cart->id }}">
                                                <td class="product-item-wish border-0">
                                                    <div class="d-flex align-items-center"
                                                        style="display: flex; align-items: center; gap: 15px;">
                                                        <div class="check-box">
                                                            <input type="checkbox" class="myproject-checkbox">
                                                        </div>
                                                        <div class="images" style="flex-shrink: 0;">
                                                            <span>
                                                                <img src="{{ asset('storage/' . $cart->product?->thumbnail) }}"
                                                                    alt="{{ $cart->product?->name }}"
                                                                    style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px;">
                                                            </span>
                                                        </div>
                                                        <div class="product">
                                                            <ul style="list-style: none; padding: 0; margin: 0;">
                                                                <li class="first-cart" style="font-weight: 600;">
                                                                    {{ $cart->product?->name }}
                                                                </li>
                                                                <li>
                                                                    <div class="rating-product"
                                                                        style="color: #ffb400; font-size: 13px;">
                                                                        <i class="fi flaticon-star"></i>
                                                                        <i class="fi flaticon-star"></i>
                                                                        <i class="fi flaticon-star"></i>
                                                                        <i class="fi flaticon-star"></i>
                                                                        <i class="fi flaticon-star"></i>
                                                                        <span
                                                                            style="color: #666; font-size: 12px; margin-left: 4px;">({{ $cart->product?->reviews->count() }})</span>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="price unit-price" style="vertical-align: middle;"
                                                    data-price="{{ $price }}">
                                                    ${{ number_format($price, 2) }}
                                                </td>



                                                <td class="td-quantity" style="vertical-align: middle;">
                                                    <div class="custom-cart-qty d-flex align-items-center"
                                                        style="display: flex; gap: 5px;">
                                                        <button type="button"
                                                            class="btn btn-sm btn-outline-secondary custom-btn-dec">-</button>
                                                        <input class="text-value qty-input text-center" type="text"
                                                            value="{{ $cart->quantity }}" readonly
                                                            style="width: 40px; text-align: center;">
                                                        <button type="button"
                                                            class="btn btn-sm btn-outline-secondary custom-btn-inc">+</button>
                                                    </div>
                                                </td>

                                                <td class="price item-subtotal" style="vertical-align: middle;">
                                                    ${{ number_format($subtotal, 2) }}
                                                </td>

                                                <td class="action" style="vertical-align: middle;">
                                                    <ul style="list-style: none; padding: 0; margin: 0;">
                                                        <li class="w-btn">
                                                            <form action="{{ route('cart.destroy', $cart->id) }}"
                                                                method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    onclick="return confirm('Remove item from cart?')"
                                                                    style="background:none; border:none; color:#ff4d4f; cursor:pointer; padding:0; font-size: 18px;">
                                                                    <i class="fi ti-trash"></i>
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-4"
                                                    style="text-align: center; padding: 20px 0;">
                                                    Your cart is empty!
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="cart-action">
                            <form id="coupon-form" class="apply-area">
                                @csrf
                                <input type="text" name="coupon_code" id="coupon_code" class="form-control"
                                    placeholder="Enter your coupon" required>
                                <button class="theme-btn-s2" type="submit">Apply</button>
                            </form>
                            <button class="theme-btn-s2 btn-reload-cart border-0" onclick="location.reload();">
                                <i class="fi flaticon-refresh"></i> Update Cart
                            </button>
                        </div>
                        <div id="coupon-message" class="mt-2"></div>
                    </div>

                    <div class="col-lg-4 col-12">
                        <div class="cart-total-wrap">
                            <h3>Cart Totals</h3>

                            @php
                                $subtotal = $totalSum ?? 0;
                                // কার্ট খালি থাকলে সেশন কুপন ধরবে না
                                $coupon = $subtotal > 0 ? session('coupon') : null;
                                $discount = $coupon['discount'] ?? 0;
                                $couponName = $coupon['code'] ?? ($coupon['name'] ?? '');
                                $grandTotal = max(0, $subtotal - $discount);
                            @endphp

                            <!-- Subtotal -->
                            <div class="d-flex justify-content-between mb-1">
                                <span>Subtotal:</span>
                                <span id="cart-subtotal">${{ number_format($subtotal, 2) }}</span>
                            </div>

                            <!-- Discount -->
                            <div class="d-flex justify-content-between mb-1">
                                <span>Discount:</span>
                                <span id="cart-discount">-${{ number_format($discount, 2) }}</span>
                            </div>

                            <!-- Grand Total -->
                            <div class="d-flex justify-content-between mb-3">
                                <strong>Total:</strong>
                                <strong id="cart-grand-total">${{ number_format($grandTotal, 2) }}</strong>
                            </div>

                            <a class="theme-btn-s2" href="{{ route('checkout') }}">Proceed To CheckOut</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {

            let updateTimer;

            // Current coupon discount
            let currentDiscount = {{ $discount ?? 0 }};

            // Page load
            calculateCartTotals();


            // ==========================================
            // COUPON APPLY
            // ==========================================

            $('#coupon-form').on('submit', function(e) {

                e.preventDefault();

                let $form = $(this);
                let $button = $form.find('button[type="submit"]');
                let couponCode = $('#coupon_code').val().trim();

                if (!couponCode) {

                    $('#coupon-message')
                        .removeClass('text-success')
                        .addClass('text-danger')
                        .text('Please enter a coupon code.');

                    return;
                }

                $button
                    .prop('disabled', true)
                    .text('Applying...');

                $.ajax({

                    url: "{{ route('coupon.apply') }}",

                    type: "POST",

                    data: {
                        _token: "{{ csrf_token() }}",
                        coupon_code: couponCode
                    },

                    success: function(response) {

                        if (response.status === 'success') {

                            currentDiscount =
                                parseFloat(response.discount_amount) || 0;

                            let subtotal =
                                parseFloat(response.subtotal) || 0;

                            let grandTotal =
                                parseFloat(response.grand_total) || 0;

                            // Subtotal
                            $('#cart-subtotal')
                                .text('$' + subtotal.toFixed(2));

                            // Discount
                            $('#cart-discount')
                                .text('-$' + currentDiscount.toFixed(2));

                            // Grand total
                            $('#cart-grand-total')
                                .text('$' + grandTotal.toFixed(2));

                            // Message
                            $('#coupon-message')
                                .removeClass('text-danger')
                                .addClass('text-success')
                                .text(
                                    response.message +
                                    ' (' +
                                    response.coupon_name +
                                    ')'
                                );
                        }
                    },

                    error: function(xhr) {

                        let message = 'Unable to apply coupon.';

                        if (
                            xhr.responseJSON &&
                            xhr.responseJSON.message
                        ) {
                            message = xhr.responseJSON.message;
                        }

                        currentDiscount = 0;

                        $('#cart-discount')
                            .text('-$0.00');

                        calculateCartTotals();

                        $('#coupon-message')
                            .removeClass('text-success')
                            .addClass('text-danger')
                            .text(message);
                    },

                    complete: function() {

                        $button
                            .prop('disabled', false)
                            .text('Apply');
                    }
                });
            });


            // ==========================================
            // INCREMENT
            // ==========================================

            $(document)
                .off(
                    'click',
                    '.custom-btn-inc, .inc'
                )
                .on(
                    'click',
                    '.custom-btn-inc, .inc',
                    function(e) {

                        e.preventDefault();

                        let $row =
                            $(this).closest('.cart-row, tr');

                        let $input =
                            $row.find('.qty-input, .text-value');

                        let currentQty =
                            parseInt($input.val()) || 1;

                        let newQty =
                            currentQty + 1;

                        $input.val(newQty);

                        updateRowAndTotals(
                            $row,
                            newQty
                        );
                    }
                );


            // ==========================================
            // DECREMENT
            // ==========================================

            $(document)
                .off(
                    'click',
                    '.custom-btn-dec, .dec'
                )
                .on(
                    'click',
                    '.custom-btn-dec, .dec',
                    function(e) {

                        e.preventDefault();

                        let $row =
                            $(this).closest('.cart-row, tr');

                        let $input =
                            $row.find('.qty-input, .text-value');

                        let currentQty =
                            parseInt($input.val()) || 1;

                        if (currentQty > 1) {

                            let newQty =
                                currentQty - 1;

                            $input.val(newQty);

                            updateRowAndTotals(
                                $row,
                                newQty
                            );
                        }
                    }
                );


            // ==========================================
            // QUANTITY CHANGE
            // ==========================================

            $(document)
                .on(
                    'change keyup',
                    '.qty-input, .text-value',
                    function() {

                        let $row =
                            $(this).closest('.cart-row, tr');

                        let qty =
                            parseInt($(this).val()) || 1;

                        if (qty < 1) {

                            qty = 1;

                            $(this).val(1);
                        }

                        updateRowAndTotals(
                            $row,
                            qty
                        );
                    }
                );


            // ==========================================
            // UPDATE ROW
            // ==========================================

            function updateRowAndTotals(
                $row,
                newQty
            ) {

                let cartId =
                    $row.data('id');

                let unitPriceText =
                    $row.find('.unit-price').data('price') ||
                    $row.find('.unit-price')
                    .text()
                    .replace('$', '')
                    .replace(',', '')
                    .trim();

                let unitPrice =
                    parseFloat(unitPriceText) || 0;

                let itemSubtotal =
                    unitPrice * newQty;

                // Row subtotal
                $row.find(
                    '.item-subtotal, .subtotal-price'
                ).text(
                    '$' + itemSubtotal.toFixed(2)
                );

                // Update frontend total
                calculateCartTotals();


                // AJAX backend update
                if (cartId) {

                    clearTimeout(updateTimer);

                    updateTimer = setTimeout(function() {

                        $.ajax({

                            url: "{{ route('cart.update.qty') }}",

                            type: "POST",

                            data: {

                                _token: "{{ csrf_token() }}",

                                cart_id: cartId,

                                quantity: newQty
                            },

                            success: function(response) {

                                if (
                                    response.status ===
                                    'success'
                                ) {

                                    // Backend coupon discount
                                    if (
                                        response.has_coupon &&
                                        response.discount_amount !==
                                        undefined
                                    ) {

                                        currentDiscount =
                                            parseFloat(
                                                response.discount_amount
                                            ) || 0;

                                    }

                                    calculateCartTotals();
                                }
                            }
                        });

                    }, 300);
                }
            }


            // ==========================================
            // CALCULATE CART TOTAL
            // ==========================================

            function calculateCartTotals() {

                let subtotal = 0;

                let itemCount = 0;


                $('.cart-row').each(function() {

                    let $row = $(this);

                    let $subtotalEl =
                        $row.find(
                            '.item-subtotal, .subtotal-price'
                        ).first();

                    if ($subtotalEl.length) {

                        let val =
                            parseFloat(
                                $subtotalEl
                                .text()
                                .replace('$', '')
                                .replace(',', '')
                                .trim()
                            ) || 0;

                        subtotal += val;

                        itemCount++;
                    }
                });


                // Empty cart
                if (
                    itemCount === 0 ||
                    subtotal === 0
                ) {

                    currentDiscount = 0;

                    $('#cart-subtotal')
                        .text('$0.00');

                    $('#cart-discount')
                        .text('-$0.00');

                    $('#cart-grand-total')
                        .text('$0.00');

                    return;
                }


                // Discount cannot be greater than subtotal
                if (currentDiscount > subtotal) {
                    currentDiscount = subtotal;
                }


                let grandTotal =
                    Math.max(
                        0,
                        subtotal - currentDiscount
                    );


                // Update UI
                $('#cart-subtotal')
                    .text(
                        '$' + subtotal.toFixed(2)
                    );

                $('#cart-discount')
                    .text(
                        '-$' +
                        currentDiscount.toFixed(2)
                    );

                $('#cart-grand-total')
                    .text(
                        '$' +
                        grandTotal.toFixed(2)
                    );
            }

        });
    </script>
@endpush
