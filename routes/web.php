<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Admin\WishlistController as AdminWishlistController;
use App\Http\Controllers\Frontend\AuthController as FrontendAuthController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Frontend\ContactQuestionController;
use App\Http\Controllers\Admin\ContactQuestionController as AdminQuestionController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Frontend\SetDataController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Frontend\ReviewController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\InstagramFeedController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\NewsletterController;
use Illuminate\Routing\Controllers\Middleware;

// Route::get('/', function () {
//     return view('welcome');
// });

// frontend route
Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home.index');
    Route::get('/shop', 'shop')->name('home.shop');

    // === এই ২টি রাউট নতুন যোগ করুন ===
    Route::get('/category/{slug}', 'categoryProducts')->name('category.products');
    Route::get('/subcategory/{slug}', 'subCategoryProducts')->name('subcategory.products');

    Route::get('/single-product/{product:slug}', 'show')->name('single-product');
    Route::get('/about', 'about')->name('home.about');
    Route::get('/contact', 'contact')->name('home.contact');
    Route::get('/faq', 'faq')->name('home.faq');
    Route::get('/compare', 'compare')->name('compare');
    Route::get('/compare/add/{id}', 'addToCompare')->name('compare.add');
    Route::get('/compare/remove/{id}', 'removeFromCompare')->name('compare.remove');
    Route::get('/recent-view', 'recentView')->name('recent-view');
    Route::get('/forget-password', 'forgetPassword')->name('forget-password');
    Route::post('/forget-password', 'forgetPasswordStore')->name('forget-password.store');
});


Route::get('/switch-language/{lang}', [SetDataController::class, 'switchLanguage'])->name('lang.switch');
Route::get('/switch-currency/{currency}', [SetDataController::class, 'switchCurrency'])->name('currency.switch');

// Frontend Route
// Contact Page দেখানোর জন্য
Route::get('/contact', [ContactQuestionController::class, 'index'])->name('home.contact');
Route::post('/faq-question/store', [ContactQuestionController::class, 'store'])->name('contact.store');
// =====================================================
// Customer Authentication
// =====================================================

Route::controller(FrontendAuthController::class)->group(function () {

    Route::get('/login', 'login')
        ->name('login');

    Route::post('/login', 'store')
        ->name('login.store');

    Route::get('/register', 'register')
        ->name('register');

    Route::post('/register', 'registerStore')
        ->name('register.store');

    Route::post('/logout', 'logout')
        ->middleware('auth')
        ->name('logout');
});

// =====================================================
// Customer Account
// =====================================================

Route::middleware('auth')->group(function () {

    Route::get('/user/profile', [HomeController::class, 'profile'])
        ->name('user.profile');

    // এই নতুন রাউটটি যুক্ত করুন
    Route::put('/user/profile', [HomeController::class, 'updateProfile'])
        ->name('user.profile.update');

    Route::get('/user/orders', [HomeController::class, 'orders'])
        ->name('user.orders');

    Route::get('/user/orders/{id}', [HomeController::class, 'orderDetails'])
        ->name('user.order-details');
});


// Newsletter
Route::post('/subscribe', [NewsletterController::class, 'subscribe'])->name('subscribe');

//wishlisht
Route::middleware(['auth'])->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
});

// Frontend Routes (Customer access)
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'store'])->name('cart.store');
    Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    // User Cart & Coupon Routes
    Route::post('/cart/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.update.qty');
    Route::post('/coupon/apply', [CartController::class, 'applyCoupon'])->name('coupon.apply');
    Route::delete('/cart/remove/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
});


Route::middleware('auth')->group(function () {
    Route::post(
        '/products/{product}/reviews',
        [ReviewController::class, 'store']
    )->name('frontend.reviews.store');
});


// Backend routes
Route::prefix('admin')->group(function () {

    // Auth routes
    Route::controller(AuthController::class)->group(function () {

        Route::get('/register', 'register')->name('auth.register');
        Route::post('/register', 'registerStore')->name('auth.register.store');
        Route::get('/login', 'login')->name('auth.login');
        Route::post('/login', 'store')->name('auth.store');
        Route::post('/logout', 'logout')->name('auth.logout');
    });


    // dashboard routes
    Route::middleware('auth')->controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard.index');
    });

    // Category routes
    Route::middleware('auth')->controller(CategoryController::class)->group(function () {
        Route::get('/categories', 'index')->name('categories.index');
        Route::get('/categories/create', 'create')->name('categories.create');
        Route::post('/categories', 'store')->name('categories.store');
        Route::get('/categories/{category}/edit', 'edit')->name('categories.edit');
        Route::put('/categories/{category}', 'update')->name('categories.update');
        Route::delete('/categories/{category}', 'destroy')->name('categories.destroy');
        Route::get('/categories/trash', 'trash')->name('categories.trash');
        Route::patch('/categories/{category}/restore', 'restore')->withTrashed()->name('categories.restore');
        Route::delete('/categories/{category}/force-delete', 'forceDelete')->name('categories.force-delete');
    });

    // Size routes
    Route::middleware('auth')->controller(SizeController::class)->group(function () {
        Route::get('/sizes', 'index')->name('sizes.index');
        Route::get('/sizes/create', 'create')->name('sizes.create');
        Route::post('/sizes', 'store')->name('sizes.store');
        Route::get('/sizes/{size}/edit', 'edit')->name('sizes.edit');
        Route::put('/sizes/{size}', 'update')->name('sizes.update');
        Route::delete('/sizes/{size}', 'destroy')->name('sizes.destroy');
        Route::get('/sizes/trash', 'trash')->name('sizes.trash');
        Route::patch('/sizes/{size}/restore', 'restore')->withTrashed()->name('sizes.restore');
        Route::delete('/sizes/{size}/force-delete', 'forceDelete')->name('sizes.force-delete');
    });

    // Color Routes
    Route::middleware('auth')->controller(ColorController::class)->group(function () {
        Route::get('/colors', 'index')->name('colors.index');
        Route::get('/colors/create', 'create')->name('colors.create');
        Route::post('/colors', 'store')->name('colors.store');
        Route::get('/colors/{color}/edit', 'edit')->name('colors.edit');
        Route::put('/colors/{color}', 'update')->name('colors.update');
        Route::delete('/colors/{color}', 'destroy')->name('colors.destroy');
        Route::get('/colors/trash', 'trash')->name('colors.trash');
        Route::patch('/colors/{color}/restore', 'restore')->withTrashed()->name('colors.restore');
        Route::delete('/colors/{color}/force-delete', 'forceDelete')->name('colors.force-delete');
    });

    // Tag routes
    Route::middleware('auth')->controller(TagController::class)->group(function () {
        Route::get('/tags', 'index')->name('tags.index');
        Route::get('/tags/create', 'create')->name('tags.create');
        Route::post('/tags', 'store')->name('tags.store');
        Route::get('/tags/{tag}/edit', 'edit')->name('tags.edit');
        Route::put('/tags/{tag}', 'update')->name('tags.update');
        Route::delete('/tags/{tag}', 'destroy')->name('tags.destroy');
        Route::get('/tags/trash', 'trash')->name('tags.trash');
        Route::patch('/tags/{tag}/restore', 'restore')->withTrashed()->name('tags.restore');
        Route::delete('/tags/{tag}/force-delete', 'forceDelete')->name('tags.force-delete');
    });

    // Brand Routes
    Route::middleware('auth')->controller(BrandController::class)->group(function () {
        Route::get('/brands', 'index')->name('brands.index');
        Route::get('/brands/create', 'create')->name('brands.create');
        Route::post('/brands', 'store')->name('brands.store');
        Route::get('/brands/{brand}/edit', 'edit')->name('brands.edit');
        Route::put('/brands/{brand}', 'update')->name('brands.update');
        Route::delete('/brands/{brand}', 'destroy')->name('brands.destroy');
        Route::get('/brands/trash', 'trash')->name('brands.trash');
        Route::patch('/brands/{brand}/restore', 'restore')->withTrashed()->name('brands.restore');
        Route::delete('/brands/{brand}/force-delete', 'forceDelete')->name('brands.force-delete');
    });

    // Sub-Category Routes
    Route::middleware('auth')->controller(SubCategoryController::class)->group(function () {
        Route::get('/sub-categories', 'index')->name('sub-categories.index');
        Route::get('/sub-categories/create', 'create')->name('sub-categories.create');
        Route::post('/sub-categories', 'store')->name('sub-categories.store');
        Route::get('/sub-categories/{subCategory}/edit', 'edit')->name('sub-categories.edit');
        Route::put('/sub-categories/{subCategory}', 'update')->name('sub-categories.update');
        Route::delete('/sub-categories/{subCategory}', 'destroy')->name('sub-categories.destroy');
        Route::get('/sub-categories/trash', 'trash')->name('sub-categories.trash');
        Route::patch('/sub-categories/{subCategory}/restore', 'restore')->withTrashed()->name('sub-categories.restore');
        Route::delete('/sub-categories/{subCategory}/force-delete', 'forceDelete')->name('sub-categories.force-delete');
    });


    // Products Routes
    Route::middleware('auth')->controller(ProductController::class)->group(function () {
        Route::get('/products', 'index')->name('products.index');
        Route::get('/products/create', 'create')->name('products.create');
        Route::post('/products', 'store')->name('products.store');
        Route::get('/products/{product}/edit', 'edit')->name('products.edit');
        Route::put('/products/{product}', 'update')->name('products.update');
        Route::delete('/products/{product}', 'destroy')->name('products.destroy');
        Route::get('/products/trash', 'trash')->name('products.trash');
        Route::patch('/products/{id}/restore', 'restore')->withTrashed()->name('products.restore');
        Route::delete('/products/{id}/force-delete', 'forceDelete')->name('products.force-delete');


        Route::post('/products/{product}/images', 'addImage')->name('products.images.add');
        Route::delete('/products/{product}/images/{image}', 'deleteImage')->name('products.images.delete');
        Route::patch('/products/{product}/images/{image}/primary', 'setPrimaryImage')->name('products.images.primary');
    });

    //newsletter
    Route::middleware(['auth'])->group(function () {
        // Subscribers
        Route::get('/subscribers', [NewsletterController::class, 'index'])->name('subscribers.index');
        Route::delete('/subscribers/{id}', [NewsletterController::class, 'destroy'])->name('subscribers.destroy');

        // Soft Delete / Trash Routes
        Route::get('/subscribers/trash', [NewsletterController::class, 'trash'])->name('subscribers.trash');
        Route::get('/subscribers/restore/{id}', [NewsletterController::class, 'restore'])->name('subscribers.restore');
        Route::delete('/subscribers/force-delete/{id}', [NewsletterController::class, 'forceDelete'])->name('subscribers.forceDelete');
    });

    // Admin Routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/wishlists', [AdminWishlistController::class, 'index'])->name('wishlists.index');
        Route::delete('/wishlists/{id}', [AdminWishlistController::class, 'destroy'])->name('wishlists.destroy');
    });

    // Admin Coupon Routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/coupons', [CouponController::class, 'index'])->name('coupons.index');
        Route::get('/coupons/create', [CouponController::class, 'create'])->name('coupons.create');
        Route::post('/coupons/store', [CouponController::class, 'store'])->name('coupons.store');

        // এডিট এবং আপডেট রাউট
        Route::get('/coupons/{id}/edit', [CouponController::class, 'edit'])->name('coupons.edit');
        Route::put('/coupons/{id}', [CouponController::class, 'update'])->name('coupons.update');

        Route::post('/coupons/{id}/toggle', [CouponController::class, 'toggleStatus'])->name('coupons.toggle');
        Route::delete('/coupons/{id}', [CouponController::class, 'destroy'])->name('coupons.destroy');
    });

    // Admin Routes (Admin Panel access)
    Route::middleware(['auth'])->group(function () {
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    });

    // Country Routes
    Route::middleware('auth')->controller(CountryController::class)->group(function () {
        Route::get('/countries', 'index')->name('countries.index');
        Route::get('/countries/create', 'create')->name('countries.create');
        Route::post('/countries', 'store')->name('countries.store');
        Route::get('/countries/{country}/edit', 'edit')->name('countries.edit');
        Route::put('/countries/{country}', 'update')->name('countries.update');
        Route::delete('/countries/{country}', 'destroy')->name('countries.destroy');
    });



    //sliders
    Route::middleware('auth')->controller(SliderController::class)->group(function () {
        Route::resource('sliders', SliderController::class);
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
    });

    Route::middleware(['auth'])->group(function () {
        Route::resource('instagram', InstagramFeedController::class)->names('instagram');
    });

    Route::middleware(['auth'])->group(function () {
        // About Section Routes
        Route::get('/about', [AboutController::class, 'edit'])->name('about.edit');
        Route::post('/about/update', [AboutController::class, 'update'])->name('about.update');


        // Service
        Route::get('/services', [ServiceController::class, 'index'])->name('service.index');
        Route::post('/services/store', [ServiceController::class, 'store'])->name('service.store');
        Route::delete('/services/destroy/{id}', [ServiceController::class, 'destroy'])->name('service.destroy');

        // Gallery
        Route::get('/galleries', [GalleryController::class, 'index'])->name('gallery.index');
        Route::post('/galleries/store', [GalleryController::class, 'store'])->name('gallery.store');
        Route::delete('/galleries/destroy/{id}', [GalleryController::class, 'destroy'])->name('gallery.destroy');

        Route::get('/faqs', [FaqController::class, 'index'])->name('faq.index');
        Route::post('/faqs/store', [FaqController::class, 'store'])->name('faq.store');
        Route::get('/faqs/edit/{id}', [FaqController::class, 'edit'])->name('faq.edit'); // Edit Route
        Route::put('/faqs/update/{id}', [FaqController::class, 'update'])->name('faq.update');
        Route::delete('/faqs/destroy/{id}', [FaqController::class, 'destroy'])->name('faq.destroy');



        Route::get('/questions', [AdminQuestionController::class, 'index'])->name('questions.index');
        Route::get('/questions/{id}', [AdminQuestionController::class, 'show'])->name('questions.show');
        Route::delete('/questions/{id}', [AdminQuestionController::class, 'destroy'])->name('questions.destroy');
    });
});
