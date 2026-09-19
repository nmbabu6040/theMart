<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Checkout Page
     */
    public function index()
    {

        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        // Cart empty হলে checkout করতে দেবে না
        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Your cart is empty!');
        }

        // Cart subtotal
        $cartTotal = $cartItems->sum(function ($cart) {
            $price = $cart->product?->discount_price;

            if (!$price || $price <= 0) {
                $price = $cart->product?->sale_price ?? 0;
            }

            return (float) $price * $cart->quantity;
        });

        // Coupon session
        $coupon = session('coupon');

        $discount = (float) ($coupon['discount'] ?? 0);

        // Discount কখনো subtotal-এর বেশি হবে না
        $discount = min($discount, $cartTotal);

        $countries = Country::orderBy('name')->get();

        // Delivery charges
        $insideCityCharge = 60;
        $outsideCityCharge = 120;

        // Default delivery charge
        $deliveryCharge = $insideCityCharge;

        // Grand total
        $grandTotal = max(
            0,
            $cartTotal - $discount + $deliveryCharge
        );

        return view('frontend.checkout', compact(
            'cartItems',
            'cartTotal',
            'discount',
            'coupon',
            'deliveryCharge',
            'grandTotal',
            'countries',
            'insideCityCharge',
            'outsideCityCharge'
        ));
    }

    /**
     * Place Order
     */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Validate Checkout Form
        |--------------------------------------------------------------------------
        */

        // dd('CHECKOUT STORE HIT', $request->all());

        $validated = $request->validate([
            // Billing
            'billing_fname' => ['required', 'string', 'max:100'],
            'billing_lname' => ['required', 'string', 'max:100'],
            'billing_country_id' => ['required', 'exists:countries,id'],
            'billing_city' => ['required', 'string', 'max:100'],
            'billing_postcode' => ['required', 'string', 'max:30'],
            'billing_company' => ['nullable', 'string', 'max:150'],
            'billing_email' => ['required', 'email', 'max:150'],
            'billing_phone' => ['required', 'string', 'max:30'],
            'billing_address' => ['required', 'string', 'max:1000'],
            'order_notes' => ['nullable', 'string', 'max:2000'],

            // Shipping
            'ship_to_different' => ['nullable', 'boolean'],
            'shipping_fname' => ['nullable', 'string', 'max:100'],
            'shipping_lname' => ['nullable', 'string', 'max:100'],
            'shipping_country_id' => ['nullable', 'exists:countries,id'],
            'shipping_city' => ['nullable', 'string', 'max:100'],
            'shipping_postcode' => ['nullable', 'string', 'max:30'],
            'shipping_company' => ['nullable', 'string', 'max:150'],
            'shipping_email' => ['nullable', 'email', 'max:150'],
            'shipping_phone' => ['nullable', 'string', 'max:30'],
            'shipping_address' => ['nullable', 'string', 'max:1000'],

            // Delivery
            'delivery_charge' => ['required', 'numeric'],

            // Payment
            'payment_method' => [
                'required',
                'in:cod,sslcommerz,stripe',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | 2. Shipping Validation
        |--------------------------------------------------------------------------
        */

        $shipToDifferent = $request->boolean('ship_to_different');

        if ($shipToDifferent) {
            $request->validate([
                'shipping_fname' => ['required', 'string', 'max:100'],
                'shipping_lname' => ['required', 'string', 'max:100'],
                'shipping_country_id' => ['required', 'exists:countries,id'],
                'shipping_city' => ['required', 'string', 'max:100'],
                'shipping_postcode' => ['required', 'string', 'max:30'],
                'shipping_phone' => ['required', 'string', 'max:30'],
                'shipping_address' => ['required', 'string', 'max:1000'],
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 3. Validate Delivery Charge From Server
        |--------------------------------------------------------------------------
        |
        | Browser থেকে কেউ 60/120 পরিবর্তন করে পাঠালেও accept করব না।
        |
        */

        $allowedDeliveryCharges = [60, 120];
        $deliveryCharge = (int) $validated['delivery_charge'];

        if (!in_array($deliveryCharge, $allowedDeliveryCharges, true)) {
            return back()->withInput()->with('error', 'Invalid delivery charge selected.');
        }

        /*
        |--------------------------------------------------------------------------
        | 4. Get Current User Cart
        |--------------------------------------------------------------------------
        */

        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();



        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Your cart is empty!');
        }

        /*
        |--------------------------------------------------------------------------
        | 5. Calculate Subtotal From Database
        |--------------------------------------------------------------------------
        |
        | Browser-এর subtotal/total কখনো trust করা হবে না।
        |
        */

        $subtotal = $cartItems->sum(function ($cart) {
            $price = $cart->product?->discount_price;

            if (!$price || $price <= 0) {
                $price = $cart->product?->sale_price ?? 0;
            }

            return (float) $price * $cart->quantity;
        });

        if ($subtotal <= 0) {
            return back()
                ->withInput()
                ->with('error', 'Your cart total is invalid.');
        }

        /*
        |--------------------------------------------------------------------------
        | 6. Coupon Discount
        |--------------------------------------------------------------------------
        */

        $coupon = session('coupon');

        $discount = 0;
        $couponCode = null;

        if ($coupon) {
            $discount = (float) ($coupon['discount'] ?? 0);
            $couponCode = $coupon['code'] ?? null;

            // Discount subtotal-এর বেশি হতে পারবে না
            $discount = min($discount, $subtotal);
        }

        /*
        |--------------------------------------------------------------------------
        | 7. Calculate Grand Total
        |--------------------------------------------------------------------------
        */

        $totalAmount = max(
            0,
            $subtotal - $discount + $deliveryCharge
        );

        /*
        |--------------------------------------------------------------------------
        | 8. Payment Status
        |--------------------------------------------------------------------------
        */

        $paymentStatus = 'pending';

        /*
        |--------------------------------------------------------------------------
        | 9. Order Status
        |--------------------------------------------------------------------------
        */

        $orderStatus = 'pending';

        /*
        |--------------------------------------------------------------------------
        | 10. Create Order + Order Items
        |--------------------------------------------------------------------------
        */

        try {
            $order = DB::transaction(function () use (
                $validated,
                $cartItems,
                $shipToDifferent,
                $subtotal,
                $discount,
                $couponCode,
                $deliveryCharge,
                $totalAmount,
                $paymentStatus,
                $orderStatus
            ) {
                /*
                |--------------------------------------------------------------------------
                | Generate Unique Order Number
                |--------------------------------------------------------------------------
                */

                do {
                    $orderNumber = 'ORD-' .
                        Carbon::now()->format('Ymd') .
                        '-' .
                        strtoupper(Str::random(6));
                } while (
                    Order::where('order_number', $orderNumber)->exists()
                );

                /*
                |--------------------------------------------------------------------------
                | Create Order
                |--------------------------------------------------------------------------
                */

                $order = Order::create([
                    'user_id' => Auth::id(),

                    'order_number' => $orderNumber,

                    // Billing
                    'billing_fname' => $validated['billing_fname'],
                    'billing_lname' => $validated['billing_lname'],
                    'billing_country_id' => $validated['billing_country_id'],
                    'billing_city' => $validated['billing_city'],
                    'billing_postcode' => $validated['billing_postcode'],
                    'billing_company' => $validated['billing_company'] ?? null,
                    'billing_email' => $validated['billing_email'],
                    'billing_phone' => $validated['billing_phone'],
                    'billing_address' => $validated['billing_address'],
                    'order_notes' => $validated['order_notes'] ?? null,

                    // Shipping
                    'ship_to_different' => $shipToDifferent,

                    'shipping_fname' => $shipToDifferent
                        ? $validated['shipping_fname']
                        : null,

                    'shipping_lname' => $shipToDifferent
                        ? $validated['shipping_lname']
                        : null,

                    'shipping_country_id' => $shipToDifferent
                        ? $validated['shipping_country_id']
                        : null,

                    'shipping_city' => $shipToDifferent
                        ? $validated['shipping_city']
                        : null,

                    'shipping_postcode' => $shipToDifferent
                        ? $validated['shipping_postcode']
                        : null,

                    'shipping_company' => $shipToDifferent
                        ? ($validated['shipping_company'] ?? null)
                        : null,

                    'shipping_email' => $shipToDifferent
                        ? ($validated['shipping_email'] ?? null)
                        : null,

                    'shipping_phone' => $shipToDifferent
                        ? ($validated['shipping_phone'] ?? null)
                        : null,

                    'shipping_address' => $shipToDifferent
                        ? $validated['shipping_address']
                        : null,

                    // Totals
                    'subtotal' => $subtotal,
                    'discount' => $discount,
                    'coupon_code' => $couponCode,
                    'delivery_charge' => $deliveryCharge,
                    'total_amount' => $totalAmount,

                    // Payment
                    'payment_method' => $validated['payment_method'],
                    'payment_status' => $paymentStatus,

                    // Order
                    'status' => $orderStatus,
                ]);

                /*
                |--------------------------------------------------------------------------
                | Create Order Items
                |--------------------------------------------------------------------------
                */

                foreach ($cartItems as $cart) {
                    $product = $cart->product;

                    if (!$product) {
                        throw new \Exception(
                            'One of the products in your cart is no longer available.'
                        );
                    }

                    // Discount price থাকলে সেটাই final selling price
                    $price = $product->discount_price;

                    if (!$price || $price <= 0) {
                        $price = $product->sale_price ?? 0;
                    }

                    $price = (float) $price;

                    $quantity = (int) $cart->quantity;

                    $itemTotal = $price * $quantity;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'price' => $price,
                        'quantity' => $quantity,
                        'total' => $itemTotal,
                    ]);
                }

                return $order;
            });

            /*
            |--------------------------------------------------------------------------
            | 11. Empty Cart
            |--------------------------------------------------------------------------
            */

            Cart::where('user_id', Auth::id())->delete();

            /*
            |--------------------------------------------------------------------------
            | 12. Remove Coupon Session
            |--------------------------------------------------------------------------
            */

            session()->forget('coupon');

            /*
            |--------------------------------------------------------------------------
            | 13. Payment Gateway Handling
            |--------------------------------------------------------------------------
            */

            if ($order->payment_method === 'cod') {
                return redirect()
                    ->route('home.index')
                    ->with(
                        'success',
                        'Order placed successfully! Your order number is ' .
                            $order->order_number
                    );
            }

            /*
            |--------------------------------------------------------------------------
            | Online Payment
            |--------------------------------------------------------------------------
            |
            | এখানে SSLCOMMERZ / STRIPE payment gateway integration বসবে।
            |
            */

            if ($order->payment_method === 'sslcommerz') {
                return redirect()
                    ->route('home.index')
                    ->with(
                        'success',
                        'Order created successfully. SSLCOMMERZ payment integration is ready to connect.'
                    );
            }

            if ($order->payment_method === 'stripe') {
                return redirect()
                    ->route('home.index')
                    ->with(
                        'success',
                        'Order created successfully. Stripe payment integration is ready to connect.'
                    );
            }

            return redirect()
                ->route('home.index')
                ->with('success', 'Order placed successfully!');
        } catch (\Throwable $e) {

            report($e);

            return back()
                ->withInput()
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }
}
