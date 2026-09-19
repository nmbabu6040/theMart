@extends('admin.layouts.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <h2 class="mb-4">System Settings</h2>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Nav Tabs -->
                <ul class="nav nav-tabs" id="settingTab" role="tablist">
                    <li class="nav-item"><a class="nav-link active" id="general-tab" data-bs-toggle="tab"
                            href="#general">General
                            & Contact</a></li>
                    <li class="nav-item"><a class="nav-link" id="media-tab" data-bs-toggle="tab" href="#media">Logos &
                            Banners</a></li>
                    <li class="nav-item"><a class="nav-link" id="seo-tab" data-bs-toggle="tab" href="#seo">SEO &
                            Analytics</a></li>
                    <li class="nav-item"><a class="nav-link" id="social-tab" data-bs-toggle="tab" href="#social">Social &
                            Developer</a></li>
                </ul>

                <div class="tab-content border border-top-0 p-4 bg-white shadow-sm mb-4" id="settingTabContent">

                    <!-- General & Contact Tab -->
                    <div class="tab-pane fade show active" id="general">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Site Name</label>
                                <input type="text" name="site_name" class="form-control"
                                    value="{{ $setting?->site_name }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Site Title</label>
                                <input type="text" name="site_title" class="form-control"
                                    value="{{ $setting?->site_title }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Primary Email</label>
                                <input type="email" name="email" class="form-control" value="{{ $setting?->email }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Support Email</label>
                                <input type="email" name="support_email" class="form-control"
                                    value="{{ $setting?->support_email }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Phone 1</label>
                                <input type="text" name="phone_1" class="form-control" value="{{ $setting?->phone_1 }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Phone 2</label>
                                <input type="text" name="phone_2" class="form-control" value="{{ $setting?->phone_2 }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>WhatsApp Number</label>
                                <input type="text" name="whatsapp_number" class="form-control"
                                    value="{{ $setting?->whatsapp_number }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Address</label>
                                <textarea name="address" class="form-control" rows="2">{{ $setting?->address }}</textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>About Us (Footer Text)</label>
                                <textarea name="about_us" class="form-control" rows="2">{{ $setting?->about_us }}</textarea>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Currency Symbol</label>
                                <input type="text" name="currency_symbol" class="form-control"
                                    value="{{ $setting?->currency_symbol ?? '$' }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Currency Code</label>
                                <input type="text" name="currency_code" class="form-control"
                                    value="{{ $setting?->currency_code ?? 'USD' }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Copyright Text</label>
                                <input type="text" name="copyright_text" class="form-control"
                                    value="{{ $setting?->copyright_text }}">
                            </div>
                        </div>
                    </div>

                    <!-- Logos & Banners Tab -->
                    <div class="tab-pane fade" id="media">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label>Header Logo</label>
                                @if ($setting?->logo)
                                    <br><img src="{{ asset('storage/' . $setting->logo) }}" height="40" class="my-2">
                                @endif
                                <input type="file" name="logo" class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Footer Logo</label>
                                @if ($setting?->footer_logo)
                                    <br><img src="{{ asset('storage/' . $setting->footer_logo) }}" height="40"
                                        class="my-2">
                                @endif
                                <input type="file" name="footer_logo" class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Favicon</label>
                                @if ($setting?->favicon)
                                    <br><img src="{{ asset('storage/' . $setting->favicon) }}" height="30"
                                        class="my-2">
                                @endif
                                <input type="file" name="favicon" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Shop Page Banner</label>
                                <input type="file" name="shop_page_banner" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Contact Page Banner</label>
                                <input type="file" name="contact_page_banner" class="form-control">
                            </div>
                        </div>
                    </div>

                    <!-- SEO & Analytics Tab -->
                    <div class="tab-pane fade" id="seo">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Meta Title</label>
                                <input type="text" name="meta_title" class="form-control"
                                    value="{{ $setting?->meta_title }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Meta Author</label>
                                <input type="text" name="meta_author" class="form-control"
                                    value="{{ $setting?->meta_author }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Meta Keywords</label>
                                <textarea name="meta_keywords" class="form-control" rows="2">{{ $setting?->meta_keywords }}</textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Meta Description</label>
                                <textarea name="meta_description" class="form-control" rows="2">{{ $setting?->meta_description }}</textarea>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Google Analytics ID</label>
                                <input type="text" name="google_analytics_id" class="form-control"
                                    placeholder="G-XXXXXXX" value="{{ $setting?->google_analytics_id }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Facebook Pixel ID</label>
                                <input type="text" name="facebook_pixel_id" class="form-control"
                                    value="{{ $setting?->facebook_pixel_id }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Sitemap URL</label>
                                <input type="text" name="sitemap_url" class="form-control" placeholder="sitemap.xml"
                                    value="{{ $setting?->sitemap_url }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Google Map</label>
                                <input type="url" name="google_map_url" class="form-control"
                                    value="{{ $setting?->google_map_url }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Custom Head Scripts</label>
                                <textarea name="custom_head_script" class="form-control" rows="3" placeholder="<script>
                                    ...
                                </script>">{{ $setting?->custom_head_script }}</textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Custom Body Scripts</label>
                                <textarea name="custom_body_script" class="form-control" rows="3" placeholder="<script>
                                    ...
                                </script>">{{ $setting?->custom_body_script }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Social & Developer Tab -->
                    <div class="tab-pane fade" id="social">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label>Facebook</label>
                                <input type="text" name="facebook" class="form-control"
                                    value="{{ $setting?->facebook }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Twitter</label>
                                <input type="text" name="twitter" class="form-control"
                                    value="{{ $setting?->twitter }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>LinkedIn</label>
                                <input type="text" name="linkedin" class="form-control"
                                    value="{{ $setting?->linkedin }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Instagram</label>
                                <input type="text" name="instagram" class="form-control"
                                    value="{{ $setting?->instagram }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>YouTube</label>
                                <input type="text" name="youtube" class="form-control"
                                    value="{{ $setting?->youtube }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Pinterest</label>
                                <input type="text" name="pinterest" class="form-control"
                                    value="{{ $setting?->pinterest }}">
                            </div>
                            <hr class="my-3">
                            <div class="col-md-6 mb-3">
                                <label>Developed By Text</label>
                                <input type="text" name="developed_by" class="form-control"
                                    placeholder="Developed by YourCompany" value="{{ $setting?->developed_by }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Developer Link</label>
                                <input type="text" name="developer_link" class="form-control"
                                    placeholder="https://yourwebsite.com" value="{{ $setting?->developer_link }}">
                            </div>
                        </div>
                    </div>

                </div>

                <button type="submit" class="btn btn-primary btn-lg">Save Settings</button>
            </form>
        </div>
    </div>
@endsection
