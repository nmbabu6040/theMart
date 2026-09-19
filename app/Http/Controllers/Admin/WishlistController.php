<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\User;

class WishlistController extends Controller
{
    // ১. অ্যাডমিনে অল উইশলিস্ট ডেটা দেখা
    public function index()
    {
        $wishlists = Wishlist::with(['user', 'product'])->latest()->paginate(15);

        return view('admin.wishlist.index', compact('wishlists'));
    }

    // ২. এডমিন থেকে উইশলিস্ট এন্ট্রি ডিলিট করা
    public function destroy($id)
    {
        $wishlist = Wishlist::findOrFail($id);
        $wishlist->delete();

        return back()->with('success', 'Wishlist item deleted successfully!');
    }
}
