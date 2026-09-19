<!-- start of wpo-site-footer-section -->
<footer class="wpo-site-footer">
    <div class="wpo-upper-footer">
        <div class="container">
            <div class="row">

                <!-- 1. About & Logo Widget -->
                <div class="col col-lg-3 col-md-6 col-sm-12 col-12">
                    <div class="widget about-widget">
                        <div class="logo widget-title">
                            <img src="{{ $siteSetting?->footer_logo ? asset('storage/' . $siteSetting->footer_logo) : ($siteSetting?->logo ? asset('storage/' . $siteSetting->logo) : asset('frontend/assets/images/logo-2.svg')) }}"
                                alt="{{ $siteSetting?->site_name }}">
                        </div>
                        <p>{{ $siteSetting?->about_us ?? 'Elit commodo nec urna erat morbi at hac turpis aliquam.' }}
                        </p>

                        <!-- Social Links -->
                        <ul>
                            @if ($siteSetting?->facebook)
                                <li><a href="{{ $siteSetting->facebook }}" target="_blank"><i
                                            class="ti-facebook"></i></a></li>
                            @endif
                            @if ($siteSetting?->twitter)
                                <li><a href="{{ $siteSetting->twitter }}" target="_blank"><i
                                            class="ti-twitter-alt"></i></a></li>
                            @endif
                            @if ($siteSetting?->linkedin)
                                <li><a href="{{ $siteSetting->linkedin }}" target="_blank"><i
                                            class="ti-linkedin"></i></a></li>
                            @endif
                            @if ($siteSetting?->instagram)
                                <li><a href="{{ $siteSetting->instagram }}" target="_blank"><i
                                            class="ti-instagram"></i></a></li>
                            @endif
                            @if ($siteSetting?->youtube)
                                <li><a href="{{ $siteSetting->youtube }}" target="_blank"><i class="ti-youtube"></i></a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>

                <!-- 2. Contact Us Widget -->
                <div class="col col-lg-3 col-md-6 col-sm-12 col-12">
                    <div class="widget link-widget">
                        <div class="widget-title">
                            <h3>Contact Us</h3>
                        </div>
                        <div class="contact-ft">
                            <ul>
                                @if ($siteSetting?->email)
                                    <li><i class="fi flaticon-mail"></i>{{ $siteSetting->email }}</li>
                                @endif
                                @if ($siteSetting?->phone_1)
                                    <li>
                                        <i class="fi flaticon-phone"></i>{{ $siteSetting->phone_1 }}
                                        @if ($siteSetting?->phone_2)
                                            <br>{{ $siteSetting->phone_2 }}
                                        @endif
                                    </li>
                                @endif
                                @if ($siteSetting?->address)
                                    <li><i class="fi flaticon-pin"></i>{{ $siteSetting->address }}</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- 3. Popular Categories Widget -->
                <div class="col col-xl-3 col-lg-2 col-md-6 col-sm-12 col-12">
                    <div class="widget link-widget">
                        <div class="widget-title">
                            <h3>Popular</h3>
                        </div>
                        <ul>
                            @if (isset($footerCategories) && $footerCategories->count() > 0)
                                @foreach ($footerCategories as $cat)
                                    <li class="mb-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            {{-- Category Link --}}
                                            <a
                                                href="{{ route('category.products', $cat->slug) }}">{{ $cat->name }}</a>

                                            {{-- Dropdown Toggle Button (যদি সাব-ক্যাটাগরি থাকে) --}}
                                            @if (isset($cat->subCategories) && $cat->subCategories->count() > 0)
                                                <a href="#footerSubCat{{ $cat->id }}" data-bs-toggle="collapse"
                                                    class="text-muted ms-2">
                                                    <i class="fa-solid fa-chevron-down small"></i>
                                                </a>
                                            @endif
                                        </div>

                                        {{-- Collapsible Subcategory List --}}
                                        @if (isset($cat->subCategories) && $cat->subCategories->count() > 0)
                                            <ul class="collapse ps-3 mt-1" id="footerSubCat{{ $cat->id }}"
                                                style="list-style-type: square;">
                                                @foreach ($cat->subCategories as $subCat)
                                                    <li>
                                                        <a href="{{ route('subcategory.products', $subCat->slug) }}"
                                                            class="text-secondary">
                                                            {{ $subCat->name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            @else
                                <li><a href="#">Men</a></li>
                                <li><a href="#">Women</a></li>
                                <li><a href="#">Kids</a></li>
                            @endif
                        </ul>
                    </div>
                </div>

                <!-- 4. Instagram Feed / Banners Widget -->
                <div class="col col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="widget instagram">
                        <div class="widget-title">
                            <h3>Instagram</h3>
                        </div>
                        <ul class="d-flex flex-wrap">
                            @if (isset($instagramFeeds) && $instagramFeeds->count() > 0)
                                @foreach ($instagramFeeds->take(6) as $feed)
                                    <li>
                                        <a href="{{ $feed->post_url ?? ($setting->instagram_url ?? 'https://instagram.com') }}"
                                            target="_blank" rel="noopener noreferrer">
                                            <img src="{{ asset('storage/' . $feed->image) }}" alt="Instagram Post">
                                        </a>
                                    </li>
                                @endforeach
                            @else
                                @php
                                    $mainInsta = $setting->instagram_url ?? 'https://instagram.com';
                                @endphp
                                <li><a href="{{ $mainInsta }}" target="_blank" rel="noopener noreferrer"><img
                                            src="{{ asset('frontend/assets/images/instragram/1.jpg') }}"
                                            alt="Instagram Fallback"></a></li>
                                <li><a href="{{ $mainInsta }}" target="_blank" rel="noopener noreferrer"><img
                                            src="{{ asset('frontend/assets/images/instragram/2.jpg') }}"
                                            alt="Instagram Fallback"></a></li>
                                <li><a href="{{ $mainInsta }}" target="_blank" rel="noopener noreferrer"><img
                                            src="{{ asset('frontend/assets/images/instragram/3.jpg') }}"
                                            alt="Instagram Fallback"></a></li>
                                <li><a href="{{ $mainInsta }}" target="_blank" rel="noopener noreferrer"><img
                                            src="{{ asset('frontend/assets/images/instragram/4.jpg') }}"
                                            alt="Instagram Fallback"></a></li>
                                <li><a href="{{ $mainInsta }}" target="_blank" rel="noopener noreferrer"><img
                                            src="{{ asset('frontend/assets/images/instragram/2.jpg') }}"
                                            alt="Instagram Fallback"></a></li>
                                <li><a href="{{ $mainInsta }}" target="_blank" rel="noopener noreferrer"><img
                                            src="{{ asset('frontend/assets/images/instragram/1.jpg') }}"
                                            alt="Instagram Fallback"></a></li>
                            @endif
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Lower Footer -->
    <div class="wpo-lower-footer">
        <div class="container">
            <div class="row">
                <div class="col col-xs-12">
                    <p class="copyright">
                        {!! $siteSetting?->copyright_text ??
                            'Copyright &copy; ' . date('Y') . ' ' . ($siteSetting?->site_name ?? 'Themart') !!}
                        @if ($siteSetting?->developed_by)
                            by <a href="{{ $siteSetting?->developer_link ?? '#' }}"
                                target="_blank">{{ $siteSetting->developed_by }}</a>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Custom Body Scripts -->
{!! $siteSetting?->custom_body_script !!}
<!-- end of wpo-site-footer-section -->
