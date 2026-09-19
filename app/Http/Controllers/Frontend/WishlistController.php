<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Category;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // ১. ইউজার উইশলিস্ট পেজ ভিউ
    public function index()
    {
        $wishlists = Wishlist::where('user_id', Auth::id())
            ->with(['product.images'])
            ->latest()
            ->get();
        $carts = Cart::where('user_id', Auth::id())->get();

        $categories = Category::where('status', 1)->get();

        return view('frontend.wishlist', compact('wishlists', 'categories', 'carts'));
    }

    // ২. AJAX দিয়ে উইশলিস্ট টগল (Add / Remove)
    public function toggle(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'status' => 'unauthenticated',
                'message' => 'Please login to manage your wishlist!'
            ], 401);
        }

        $userId = Auth::id();
        $productId = $request->product_id;

        $wishlist = Wishlist::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            $action = 'removed';
            $message = 'Product removed from wishlist!';
        } else {
            Wishlist::create([
                'user_id' => $userId,
                'product_id' => $productId
            ]);
            $action = 'added';
            $message = 'Product added to wishlist!';
        }

        $count = Wishlist::where('user_id', $userId)->count();

        return response()->json([
            'status' => 'success',
            'action' => $action,
            'message' => $message,
            'count' => $count
        ]);
    }

    // ৩. উইশলিস্ট বা হেডারের মিনি-কার্ট থেকে আইটেম রিমুভ (AJAX & Normal Request Support)
    public function destroy(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'unauthenticated', 'message' => 'Please login first!'], 401);
        }

        $wishlist = Wishlist::where('user_id', Auth::id())->where('id', $id)->first();

        if ($wishlist) {
            $wishlist->delete();
            $count = Wishlist::where('user_id', Auth::id())->count();

            if ($request->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Product removed from wishlist!',
                    'count' => $count
                ]);
            }

            return back()->with('success', 'Product removed from wishlist!');
        }

        if ($request->ajax()) {
            return response()->json(['status' => 'error', 'message' => 'Item not found!'], 404);
        }

        return back()->with('error', 'Item not found!');
    }
}
