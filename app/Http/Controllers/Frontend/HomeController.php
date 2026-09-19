<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brand;
use App\Models\Tag;
use App\Models\Color;
use App\Models\Size;
use App\Models\OrderItem;
use App\Models\Review;
use App\Models\Cart;
use App\Models\Wishlist;
use App\Models\Order;
use App\Models\Product;
use App\Models\Slider;
use App\Models\About;
use App\Models\Service;
use App\Models\Gallery;
use App\Models\Faq;



class HomeController extends Controller
{
    public function index()
    {
        // অ্যাক্টিভ স্লাইডারগুলো সিরিয়াল অনুযায়ী আনা হচ্ছে
        $sliders = Slider::where('status', true)
            ->orderBy('serial_number', 'asc')
            ->get();

        // Categories
        $categories = Category::where('status', true)
            ->with('subCategories')
            ->orderBy('name')
            ->get();


        // Featured Products
        $featuredProducts = Product::where('status', true)
            ->where('featured', true)
            ->with(['images', 'category'])
            ->latest()
            ->take(8)
            ->get();

        // Trending Products
        $trendingProducts = Product::where('status', true)
            ->where('is_trending', true)
            ->with(['images', 'category'])
            ->latest()
            ->take(8)
            ->get();

        // Interest Products
        $interestProducts = Product::where('status', true)
            ->where('is_interest', true)
            ->with(['images', 'category'])
            ->latest('id')
            ->take(8)
            ->get();

        // Recently Added / Latest Products
        $recentlyAddedProducts = Product::where('status', true)
            ->with(['images', 'category'])
            ->latest()
            ->take(3)
            ->get();

        // Top Rated Products (যদি rating না থাকে, তবে ০ ধরবে কিন্তু SQL Error দেবে না)
        $topRatedProducts = Product::where('status', true)
            ->with(['images', 'category'])
            ->orderByDesc('rating')
            ->take(3)
            ->get();

        // Best Deals (ডিসকাউন্ট ১ বা তার বেশি থাকলে দেখাবে)
        $bestDeals = Product::where('status', true)
            ->where('discount', '>', 0)
            ->with(['images', 'category'])
            ->orderByDesc('discount')
            ->take(2)
            ->get();

        // Top Selling Products
        $topSellingProducts = Product::where('status', true)
            ->with(['images', 'category'])
            ->orderByDesc('total_sales')
            ->take(3)
            ->get();

        // Exciting offers
        $excitingOffers = Product::where('status', true)
            ->where('discount', '>', 0)
            ->orderByDesc('discount')
            ->with(['images', 'category'])
            ->take(1)
            ->get(); // অবশ্যই ->get() দিয়ে অ্যারেই/কালেকশন রিটার্ন করতে হবে

        return view('frontend.home.index', compact(
            'sliders',
            'categories',
            'featuredProducts',
            'trendingProducts',
            'topRatedProducts',
            'recentlyAddedProducts',
            'bestDeals',
            'interestProducts',
            'topSellingProducts',
            'excitingOffers'
        ));
    }

    public function about()
    {
        $about = About::first(); // প্রথম রো-এর ডাটা নিবে
        $services = Service::where('status', 1)->get();
        $galleries = Gallery::latest()->get();

        return view('frontend.home.about', compact('about', 'services', 'galleries'));
    }

    public function contact()
    {
        return view('frontend.home.contact');
    }

    public function faq()
    {
        $faqs = Faq::where('status', 1)->get();
        return view('frontend.home.faq', compact('faqs'));
    }

    public function shop(Request $request)
    {
        $categories = Category::where('status', true)->latest()->get();

        $query = Product::where('status', true)->with(['images', 'category', 'brand']);

        // ১. টেক্সট দিয়ে সার্চ ফিল্টার
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // ২. ড্রপডাউন ক্যাটাগরি ফিল্টার
        if ($request->filled('category')) {
            $categorySlug = $request->category;
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        $products = $query->latest()->paginate(18)->withQueryString();

        $newProducts = Product::where('status', true)
            ->with(['images', 'category', 'brand'])
            ->latest()
            ->take(3)
            ->get();

        $tags   = Tag::all();
        $sizes  = Size::all();
        $colors = Color::all();
        $brands = Brand::all();

        return view('frontend.home.shop', compact(
            'categories',
            'products',
            'newProducts',
            'tags',
            'sizes',
            'colors',
            'brands'
        ));
    }

    public function checkout()
    {
        return view('frontend.checkout');
    }

    public function compare()
    {
        // সেশন থেকে প্রোডাক্টের ID গুলো নেওয়া হচ্ছে
        $compareProductIds = session()->get('compare', []);

        $products = Product::query()
            ->with(['category', 'subCategory', 'brand', 'sizes', 'colors', 'tags']) // রিলেশনগুলো অবশ্যই include করতে হবে
            ->whereIn('id', $compareProductIds)
            ->get();

        return view('frontend.compare', compact('products'));
    }

    // Add to Compare
    public function addToCompare($id)
    {
        $compare = session()->get('compare', []);

        if (count($compare) >= 4 && !in_array($id, $compare)) {
            return redirect()->back()->with('error', 'Maximum 4 products can be compared!');
        }

        if (!in_array($id, $compare)) {
            $compare[] = $id;
            session()->put('compare', $compare);
            return redirect()->back()->with('success', 'Added to compare list!');
        }

        return redirect()->back()->with('info', 'Already in compare list!');
    }

    // Remove from Compare
    public function removeFromCompare($id)
    {
        $compare = session()->get('compare', []);

        if (($key = array_search($id, $compare)) !== false) {
            unset($compare[$key]);
            session()->put('compare', array_values($compare));
        }

        return redirect()->back()->with('success', 'Removed from compare list!');
    }

    public function wishlist()
    {
        $categories = Category::all();
        return view('frontend.wishlist', compact('categories'));
    }

    public function cart()
    {
        return view('frontend.cart');
    }

    // Recently Viewed Page Logic
    public function recentView()
    {
        $categories = Category::all();
        $recentlyViewedIds = session()->get('recently_viewed_products', []);

        if (!empty($recentlyViewedIds)) {
            $recentProducts = Product::whereIn('id', $recentlyViewedIds)
                ->where('status', true)
                ->orderByRaw('FIELD(id, ' . implode(',', $recentlyViewedIds) . ')')
                ->paginate(8); // get() এর জায়গায় paginate(8) ব্যবহার করা হয়েছে
        } else {
            $recentProducts = collect();
        }

        return view('frontend.recent-view', compact('categories', 'recentProducts'));
    }

    // Single Product View with Session Track
    public function show(Product $product)
    {
        $product->load([
            'category',
            'subCategory',
            'brand',
            'images',
            'sizes',
            'colors',
            'tags',
            'reviews',
        ]);

        // ================= Recently Viewed Track =================
        $recentlyViewed = session()->get('recently_viewed_products', []);

        // পূর্বে দেখা থাকলে আগের পজিশন থেকে মুছে ফেলে নতুন করে শুরুতে যুক্ত করবে
        if (($key = array_search($product->id, $recentlyViewed)) !== false) {
            unset($recentlyViewed[$key]);
        }

        // একদম শুরুতে যুক্ত করা (Unshift)
        array_unshift($recentlyViewed, $product->id);

        // সর্বোচ্চ ১০ টি প্রোডাক্ট ট্র্যাকে থাকবে
        $recentlyViewed = array_slice($recentlyViewed, 0, 10);

        // সেশনে নতুন লিস্ট সেভ করা
        session()->put('recently_viewed_products', $recentlyViewed);
        // =========================================================

        $categories = Category::all();
        return view('frontend.single-product', compact('product', 'categories'));
    }

    public function profile()
    {
        $user = Auth::user();

        return view('frontend.user.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validation
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Max 2MB
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|min:8|confirmed',
        ]);

        // Handle Profile Image Upload
        if ($request->hasFile('image')) {
            // শুধুমাত্র নতুন ফাইল আপলোড হলেই পুরনো ফাইল ডিলিট হবে
            if (!empty($user->image) && File::exists(public_path('uploads/profile/' . $user->image))) {
                File::delete(public_path('uploads/profile/' . $user->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/profile'), $imageName);

            $user->image = $imageName;
        }

        // Handle Password Change
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password does not match!']);
            }
            $user->password = Hash::make($request->password);
        }

        // Save Basic Info
        $user->name = $request->name;
        $user->email = $request->email;

        // If phone and address columns exist in your users table
        if (\Schema::hasColumn('users', 'phone')) {
            $user->phone = $request->phone;
        }
        if (\Schema::hasColumn('users', 'address')) {
            $user->address = $request->address;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function orders()
    {
        // orderItems এবং product রিলেশনশিপ eager load করা হয়েছে
        $orders = Order::where('user_id', Auth::id())
            ->with(['orderItems.product']) // orderItems এবং product দুটোই Eager Load করা থাকতে হবে
            ->latest('id')
            ->paginate(10);

        return view('frontend.user.orders', compact('orders'));
    }

    public function orderDetails($id)
    {
        // 'items.product' এর জায়গায় সঠিক রিলেশনশিপ 'orderItems.product' দেওয়া হয়েছে
        $order = Order::where('user_id', Auth::id())
            ->with(['orderItems.product'])
            ->findOrFail($id);

        return view('frontend.user.order-details', compact('order'));
    }


    // Category-wise Products Page
    public function categoryProducts($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        // সাইডবারের জন্য সব Active ক্যাটাগরি নিয়ে আসা
        $categories = Category::where('status', 1)->get();

        $products = Product::where('status', 1)
            ->where('category_id', $category->id)
            ->latest()
            ->paginate(12);

        $colors = Color::all();
        $brands = Brand::all();
        $sizes  = Size::all();
        $tags   = Tag::all();
        $newProducts = Product::where('status', true)
            ->with(['images', 'category', 'brand'])
            ->latest()
            ->take(3)
            ->get();



        // compact-এ 'categories' যোগ করুন
        return view('frontend.home.shop', compact('category', 'products', 'categories', 'colors', 'brands', 'sizes', 'tags', 'newProducts'));
    }

    // SubCategory-wise Products Page
    public function subCategoryProducts($slug)
    {
        $subCategory = SubCategory::where('slug', $slug)->firstOrFail();

        // সাইডবারের জন্য সব Active ক্যাটাগরি নিয়ে আসা
        $categories = Category::where('status', 1)->get();

        $products = Product::where('status', 1)
            ->where('sub_category_id', $subCategory->id)
            ->latest()
            ->paginate(12);
        $newProducts = Product::where('status', true)
            ->with(['images', 'category', 'brand'])
            ->latest()
            ->take(3)
            ->get();

        $colors = Color::all();
        $brands = Brand::all();
        $sizes  = Size::all();
        $tags   = Tag::all();

        // compact-এ 'categories' যোগ করুন
        return view('frontend.home.shop', compact('subCategory', 'products', 'categories', 'newProducts', 'colors', 'brands', 'sizes', 'tags'));
    }
}
