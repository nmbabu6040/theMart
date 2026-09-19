<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Cart Page View
    public function index()
    {
        $carts = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        return view('frontend.cart', compact('carts'));
    }

    // Add to Cart
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity ?? 1;
        $price = $product->discount_price ?? $product->sale_price;

        $cart = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($cart) {
            $cart->update([
                'quantity' => $cart->quantity + $quantity,
            ]);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $price,
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    // Update Quantity
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::where('user_id', Auth::id())->findOrFail($id);
        $cart->update([
            'quantity' => $request->quantity,
        ]);

        return redirect()->back()->with('success', 'Cart updated successfully!');
    }


    // ১. AJAX দিয়ে কয়ান্টিটি আপডেট
    public function updateQuantity(Request $request)
    {
        $request->validate([
            'cart_id' => 'required',
            'quantity' => 'required|numeric|min:1'
        ]);

        $cart = Cart::where('user_id', Auth::id())->where('id', $request->cart_id)->first();

        if ($cart) {
            $cart->quantity = $request->quantity;
            $cart->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Cart updated successfully!'
            ]);
        }

        return response()->json(['status' => 'error', 'message' => 'Cart item not found!'], 404);
    }

    // ২. কুপন অ্যাপ্লাই করার লজিক
    // ২. কুপন অ্যাপ্লাই করার লজিক
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => ['required', 'string', 'max:50'],
        ]);

        $code = strtoupper(trim($request->coupon_code));

        // Current cart subtotal database থেকে calculate
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Your cart is empty!',
            ], 422);
        }

        $subtotal = $cartItems->sum(function ($cart) {
            // discount_price যদি NULL না হয় এবং ০ এর চেয়ে বড় হয়, তবে সেটি নেবে; নাহলে sale_price নেবে
            $discountPrice = $cart->product?->discount_price;
            $salePrice = $cart->product?->sale_price ?? 0;

            $price = ($discountPrice && $discountPrice > 0) ? $discountPrice : $salePrice;

            return (float)$price * (int)$cart->quantity;
        });

        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid coupon code!',
            ], 422);
        }

        // Active status check
        if ((int) $coupon->status !== 1) {
            return response()->json([
                'status' => 'error',
                'message' => 'This coupon is inactive!',
            ], 422);
        }

        // Validity check
        if (!$coupon->validity || Carbon::parse($coupon->validity)->lt(Carbon::today())) {
            return response()->json([
                'status' => 'error',
                'message' => 'This coupon has expired!',
            ], 422);
        }

        // Minimum cart amount check (float kora hoyeche)
        $minCartAmount = (float) $coupon->min_cart_amount;
        if ((float) $subtotal < $minCartAmount) {
            return response()->json([
                'status' => 'error',
                'message' => 'Minimum cart amount for this coupon is $' . number_format($minCartAmount, 2),
            ], 422);
        }

        // Discount calculation
        if ($coupon->type === 'percent') {
            $discountAmount = ($subtotal * (float)$coupon->value) / 100;
        } else {
            $discountAmount = (float) $coupon->value;
        }

        // Discount subtotal এর বেশি হবে না
        $discountAmount = min($discountAmount, $subtotal);

        // Session store
        session()->put('coupon', [
            'code' => $coupon->code,
            'discount' => $discountAmount,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Coupon applied successfully!',
            'coupon_name' => $coupon->code,
            'discount_amount' => $discountAmount,
            'subtotal' => $subtotal,
            'grand_total' => max(0, $subtotal - $discountAmount),
        ]);
    }

    // Remove Single Item
    public function destroy($id)
    {
        // ১. কার্ট থেকে প্রোডাক্ট ডিলিট করুন
        $cart = Cart::findOrFail($id);
        $cart->delete();

        // ✅ ২. চেক করুন কার্ট সম্পূর্ণ খালি হয়ে গেছে কিনা
        $remainingCartCount = Cart::where('user_id', auth()->id())->count(); // বা আপনার সেশন আইডি

        if ($remainingCartCount == 0) {
            // কার্টে প্রোডাক্ট না থাকলে সেশন থেকে কুপন মুছে যাবে
            session()->forget('coupon');
        }

        return redirect()->back()->with('success', 'Item removed successfully!');
    }
}
