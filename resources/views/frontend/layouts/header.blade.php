<!-- start header -->
<header id="header" style="overflow: visible !important; position: relative; z-index: 99999;">
    {{-- start topbar --}}
    <div class="topbar">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-lg-6 col-md-12 col-sm-12 col-12">
                    <div class="contact-intro">
                        <span>{{ $setting->site_title ?? 'A Marketplace Initiative by Themart Theme - save more with coupons' }}</span>
                    </div>
                </div>
                <div class="col col-lg-6 col-md-12 col-sm-12 col-12">
                    <div class="contact-info">
                        <ul>
                            {{-- Phone 1 --}}
                            @if (!empty($setting->phone_1))
                                <li>
                                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $setting->phone_1) }}">
                                        <span>{{ __('Need help? Call Us:') }}</span> {{ $setting->phone_1 }}
                                    </a>
                                </li>
                            @endif

                            {{-- Language Switcher --}}
                            <li>
                                <div class="dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton1"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ session('locale') == 'bn' ? 'Bangla' : 'English' }}
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item"
                                                href="{{ route('lang.switch', 'en') }}">{{ __('English') }}</a>
                                        </li>
                                        <li><a class="dropdown-item"
                                                href="{{ route('lang.switch', 'bn') }}">{{ __('Bangla') }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            {{-- Currency Switcher --}}
                            <li>
                                <div class="dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton2"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ session('currency', $setting->currency_code ?? 'BDT') }}
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                        <li><a class="dropdown-item"
                                                href="{{ route('currency.switch', 'BDT') }}">{{ __('BDT') }}</a>
                                        </li>
                                        <li><a class="dropdown-item"
                                                href="{{ route('currency.switch', 'USD') }}">{{ __('USD') }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end topbar -->

    <!-- start header-middle -->
    <div class="header-middle"
        style="position: relative !important; z-index: 100 !important; overflow: visible !important;">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-2">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="{{ route('home.index') }}">
                            <img src="{{ $siteSetting?->header_logo ? asset('storage/' . $siteSetting->header_logo) : ($siteSetting?->logo ? asset('storage/' . $siteSetting->logo) : asset('frontend/assets/images/logo-2.svg')) }}"
                                alt="{{ $siteSetting?->site_name }}">
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <form action="{{ route('home.shop') }}" method="GET" class="middle-box d-flex">
                        <div class="category">
                            <select name="category" class="form-control">
                                <option value="">{{ __('All Category') }}</option>
                                @if (isset($categories) && $categories->count() > 0)
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->slug }}"
                                            {{ request('category') == $category->slug ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="search-box">
                            <div class="input-group">
                                <input type="search" name="search" class="form-control"
                                    value="{{ request('search') }}" placeholder="What are you looking for?">
                                <button class="search-btn" type="submit">
                                    <i class="fi flaticon-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="middle-right" style="overflow: visible !important;">
                        <ul class="d-flex align-items-center justify-content-end mb-0 list-unstyled"
                            style="gap: 15px; overflow: visible !important;">
                            <li>
                                <a href="{{ route('compare') }}">
                                    <i class="fi flaticon-right-and-left"></i>
                                    {{ __('Compare') }} <span>({{ count(session('compare', [])) }})</span>
                                </a>
                            </li>

                            <li class="position-relative" style="overflow: visible !important;">
                                @auth
                                    <div class="dropdown" style="overflow: visible !important;">
                                        <a class="dropdown-toggle d-flex justify-content-between align-items-center cursor-pointer"
                                            type="button" id="userAccountMenu" onclick="toggleUserMenu(event)"
                                            style="gap: 5px; text-decoration: none; cursor: pointer;">

                                            @if (!empty(Auth::user()->image) && file_exists(public_path('uploads/profile/' . Auth::user()->image)))
                                                <span
                                                    style="overflow: visible !important; width: 30px !important; height: 30px !important;">
                                                    <img src="{{ asset('uploads/profile/' . Auth::user()->image) }}"
                                                        alt="{{ Auth::user()->name }}" class="rounded-circle"
                                                        style="width: 100% !important; height: 100% !important; object-fit: cover;">
                                                </span>
                                            @else
                                                <span
                                                    style="overflow: visible !important; width: 30px !important; height: 30px !important;">
                                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D6EFD&color=fff&size=128"
                                                        alt="Default Avatar" class="rounded-circle"
                                                        style="width: 100% !important; height: 100% !important; object-fit: cover;">
                                                </span>
                                            @endif

                                            <span class="w-75">{{ Str::limit(Auth::user()->name, 7, '..') }}</span>
                                        </a>

                                        <ul class="dropdown-menu dropdown-menu-end shadow" id="userDropdownMenu"
                                            style="position: absolute !important; right: 0 !important; top: 100% !important; z-index: 99999999 !important; min-width: 180px; display: none; background: #ffffff !important; list-style: none; padding: 10px; margin-top: 5px; border-radius: 4px; box-shadow: 0 8px 20px rgba(0,0,0,0.2) !important;">
                                            <li>
                                                <a class="dropdown-item py-2 text-start"
                                                    href="{{ route('user.profile') }}">
                                                    <i class="ti-user me-2"></i>{{ __('My Profile') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item py-2" href="{{ route('user.orders') }}">
                                                    <i class="ti-bag me-2"></i>{{ __('My Orders & Tracking') }}
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider my-1">
                                            </li>
                                            <li>
                                                <form action="{{ route('logout') }}" method="POST" class="m-0">
                                                    @csrf
                                                    <button type="submit"
                                                        class="dropdown-item py-2 text-danger border-0 bg-transparent w-100 text-start cursor-pointer">
                                                        <i class="ti-power-off me-2"></i>{{ __('Logout') }}
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                @endauth

                                @guest
                                    <a href="{{ route('login') }}">
                                        <i class="fi flaticon-user-profile"></i><span>{{ __('Login') }}</span>
                                    </a>
                                @endguest
                            </li>
                            <li>
                                <div class="header-wishlist-form-wrapper">
                                    <button class="wishlist-toggle-btn">
                                        <i class="fi flaticon-heart"></i>
                                        <span class="cart-count">{{ count($wishlists ?? []) }}</span>
                                    </button>
                                    <div class="mini-wislist-content">
                                        <button class="mini-cart-close"><i class="ti-close"></i></button>
                                        <div class="mini-cart-items">
                                            @foreach ($wishlists ?? [] as $wishlist)
                                                <div
                                                    class="mini-cart-item clearfix wishlist-item-{{ $wishlist->id }}">
                                                    <div class="mini-cart-item-image">
                                                        <a href="{{ route('home.shop') }}">
                                                            <img src="{{ asset('storage/' . $wishlist->product->thumbnail) }}"
                                                                alt="">
                                                        </a>
                                                    </div>
                                                    <div class="mini-cart-item-des">
                                                        <a
                                                            href="{{ route('home.shop') }}">{{ $wishlist->product->name }}</a>
                                                        <span class="mini-cart-item-price">
                                                            ${{ $wishlist->product?->discount > 0 ? $wishlist->product?->discount_price : $wishlist->product?->sale_price }}
                                                        </span>
                                                        <span class="mini-cart-item-quantity">
                                                            <form
                                                                action="{{ route('wishlist.destroy', $wishlist->id) }}"
                                                                method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    onclick="return confirm('Remove item?')"
                                                                    style="background:none; border:none; color:red; cursor:pointer; padding:0;">
                                                                    <i class="ti-close"></i>
                                                                </button>
                                                            </form>
                                                        </span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="mini-cart-action clearfix">
                                            <div class="mini-btn">
                                                <a href="{{ route('wishlist.index') }}"
                                                    class="view-cart-btn">{{ __('View Wishlist') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="mini-cart">
                                    <button class="cart-toggle-btn">
                                        <i class="fi flaticon-add-to-cart"></i>
                                        <span class="cart-count">{{ count($carts ?? []) }}</span>
                                    </button>
                                    <div class="mini-cart-content">
                                        <button class="mini-cart-close"><i class="ti-close"></i></button>
                                        <div class="mini-cart-items">
                                            @foreach ($carts ?? [] as $cart)
                                                <div class="mini-cart-item clearfix">
                                                    <div class="mini-cart-item-image">
                                                        <a href="{{ route('home.shop') }}">
                                                            <img src="{{ asset('storage/' . $cart->product->thumbnail) }}"
                                                                alt="">
                                                        </a>
                                                    </div>
                                                    <div class="mini-cart-item-des">
                                                        <a
                                                            href="{{ route('home.shop') }}">{{ $cart->product->name }}</a>
                                                        <span class="mini-cart-item-price">
                                                            ${{ $cart->product?->discount > 0 ? $cart->product?->discount_price : $cart->product?->sale_price }}
                                                            x {{ $cart->quantity }}
                                                        </span>
                                                        <span class="mini-cart-item-quantity">
                                                            <form action="{{ route('cart.destroy', $cart->id) }}"
                                                                method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    onclick="return confirm('Remove item?')"
                                                                    style="background:none; border:none; color:red; cursor:pointer; padding:0;">
                                                                    <i class="ti-close"></i>
                                                                </button>
                                                            </form>
                                                        </span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="mini-cart-action clearfix">
                                            <div class="mini-btn">
                                                <a href="{{ route('cart.index') }}"
                                                    class="view-cart-btn">{{ __('View Cart') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end header-middle -->

    {{-- navbar start --}}
    <div class="wpo-site-header" style="position: relative !important; z-index: 10 !important;">
        <nav class="navigation navbar navbar-expand-lg navbar-light"
            style="position: relative !important; z-index: 10 !important;">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-3 d-lg-none dl-block">
                        <div class="mobail-menu">
                            <button type="button" class="navbar-toggler open-btn">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar first-angle"></span>
                                <span class="icon-bar middle-angle"></span>
                                <span class="icon-bar last-angle"></span>
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-1 col-md-6 col-sm-5 col-6 d-block d-lg-none">
                        <div class="navbar-header">
                            <a class="navbar-brand" href="{{ route('home.index') }}">
                                <img src="{{ asset('frontend/assets/images/logo.svg') }}" alt="logo">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-4 col-3">
                        <div class="header-shop-item">
                            <button class="header-shop-toggle-btn">
                                <span>{{ __('Shop By Category') }}</span>
                            </button>
                            <div class="mini-shop-item">
                                <ul id="metis-menu">
                                    @if (isset($categories) && $categories->count() > 0)
                                        @foreach ($categories as $category)
                                            @if (isset($category->subCategories) && $category->subCategories->count() > 0)
                                                <li class="header-catagory-item">
                                                    <a class="menu-down-arrow"
                                                        href="{{ route('category.products', $category->slug) }}">
                                                        {{ $category->name }}
                                                    </a>
                                                    <ul class="header-catagory-single">
                                                        @foreach ($category->subCategories as $subCategory)
                                                            <li>
                                                                <a
                                                                    href="{{ route('subcategory.products', $subCategory->slug) }}">
                                                                    {{ $subCategory->name }}
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @else
                                                <li>
                                                    <a href="{{ route('category.products', $category->slug) }}">
                                                        {{ $category->name }}
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    @endif

                                    <li><a
                                            href="{{ route('home.shop', ['featured' => 1]) }}">{{ __('Featured Products') }}</a>
                                    </li>
                                    <li><a
                                            href="{{ route('home.shop', ['sort' => 'best_selling']) }}">{{ __('Best Sellers') }}</a>
                                    </li>
                                    <li><a href="{{ route('home.shop', ['sale' => 1]) }}">{{ __('On Sale') }}</a>
                                    </li>
                                    <li><a href="{{ route('home.shop') }}">{{ __('All Products') }}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-1 col-1">
                        <div id="navbar" class="collapse navbar-collapse navigation-holder">
                            <button class="menu-close"><i class="ti-close"></i></button>
                            <ul class="nav navbar-nav mb-2 mb-lg-0">
                                <li class="menu-item-has-children {{ request()->is('/') ? 'active' : '' }}">
                                    <a href="{{ route('home.index') }}"
                                        class="{{ request()->is('/') ? 'active' : '' }}">{{ __('Home') }}</a>
                                </li>
                                <li class="menu-item-has-children {{ request()->is('about*') ? 'active' : '' }}">
                                    <a href="{{ route('home.about') }}"
                                        class="{{ request()->is('about*') ? 'active' : '' }}">{{ __('About') }}</a>
                                </li>
                                <li
                                    class="menu-item-has-children {{ request()->is('shop*') || request()->is('category*') || request()->is('subcategory*') ? 'active' : '' }}">
                                    <a href="{{ route('home.shop') }}"
                                        class="{{ request()->is('shop*') || request()->is('category*') || request()->is('subcategory*') ? 'active' : '' }}">{{ __('Shop') }}</a>
                                </li>
                                <li class="menu-item-has-children {{ request()->is('faq*') ? 'active' : '' }}">
                                    <a href="{{ route('home.faq') }}"
                                        class="{{ request()->is('faq*') ? 'active' : '' }}">{{ __('Faq') }}</a>
                                </li>
                                <li class="menu-item-has-children {{ request()->is('contact*') ? 'active' : '' }}">
                                    <a href="{{ route('home.contact') }}"
                                        class="{{ request()->is('contact*') ? 'active' : '' }}">{{ __('Contact') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-1 col-1">
                        <div class="header-right">
                            <a href="{{ route('recent-view') }}" class="recent-btn">
                                <i class="fi flaticon-refresh"></i>
                                <span>{{ __('Recently Viewed') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    {{-- navbar end --}}
</header>
<!-- end of header -->

@push('style')
    <style>
        header,
        #header,
        .topbar,
        .header-middle,
        .wpo-header-style-1,
        .wpo-site-header,
        .topbar .container,
        .topbar .container-fluid,
        .topbar .row,
        .topbar .col,
        .topbar ul,
        .topbar li {
            overflow: visible !important;
        }

        .topbar {
            position: relative !important;
            z-index: 99999999 !important;
        }

        .topbar .dropdown {
            position: relative !important;
            z-index: 999999999 !important;
        }

        .topbar .dropdown-menu {
            position: absolute !important;
            z-index: 9999999999 !important;
            top: 100% !important;
            right: 0 !important;
            left: auto !important;
            background-color: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25) !important;
            min-width: 120px !important;
            padding: 8px 0 !important;
            margin-top: 2px !important;
            display: none;
        }

        .topbar .dropdown-menu.show {
            display: block !important;
        }

        .topbar .dropdown-menu .dropdown-item {
            color: #333333 !important;
            padding: 8px 16px !important;
            font-size: 14px !important;
            display: block !important;
            white-space: nowrap !important;
            background: transparent !important;
        }

        .topbar .dropdown-menu .dropdown-item:hover {
            background-color: #f8f9fa !important;
            color: #000000 !important;
        }

        #userDropdownMenu {
            display: none;
            position: absolute !important;
            top: 100% !important;
            right: 0 !important;
            z-index: 99999999 !important;
            background-color: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2) !important;
        }
    </style>
@endpush

@push('script')
    <script>
        function toggleUserMenu(event) {
            event.stopPropagation();
            var menu = document.getElementById("userDropdownMenu");
            if (menu) {
                if (menu.style.display === "none" || menu.style.display === "") {
                    menu.style.display = "block";
                } else {
                    menu.style.display = "none";
                }
            }
        }

        document.addEventListener("click", function(event) {
            var menu = document.getElementById("userDropdownMenu");
            var button = document.getElementById("userAccountMenu");
            if (menu && button && !menu.contains(event.target) && !button.contains(event.target)) {
                menu.style.display = "none";
            }
        });
    </script>
@endpush
