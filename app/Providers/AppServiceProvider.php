<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;
use App\Models\Setting;
use App\Models\Category;
use App\Models\Cart;
use App\Models\InstagramFeed;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        // ১. Global Data Sharing for All Views (*)
        View::composer('*', function ($view) {

            // Database-এ settings টেবিল থাকলে প্রথম রেকর্ড আনবে
            $setting = null;
            if (Schema::hasTable('settings')) {
                $setting = Setting::first();
            }

            $footerCategories = Category::where('status', 1)->take(5)->get();
            $instagramFeeds = InstagramFeed::where('status', true)->latest()->take(6)->get();

            // $setting এবং $siteSetting দুটো নামেই পাঠানো হয়েছে যেন কোথাও কনফ্লিক্ট না করে
            $view->with([
                'setting'          => $setting,
                'siteSetting'      => $setting,
                'footerCategories' => $footerCategories,
                'instagramFeeds'   => $instagramFeeds,
            ]);
        });

        // ২. Header Specific View Composer
        View::composer('frontend.layouts.header', function ($view) {

            // Category Data
            $categories = Category::where('status', 1)->get();

            // Wishlist Data
            $wishlists = collect();
            if (Auth::check()) {
                $wishlists = Wishlist::where('user_id', Auth::id())
                    ->with('product')
                    ->latest()
                    ->get();
            }

            // Cart Data
            if (Auth::check()) {
                $carts = Cart::where('user_id', Auth::id())->latest()->get();
            } else {
                $carts = session()->get('cart', []);
            }

            $view->with([
                'categories' => $categories,
                'wishlists'  => $wishlists,
                'carts'      => $carts,
            ]);
        });
    }
}
