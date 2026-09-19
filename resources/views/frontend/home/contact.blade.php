@extends('frontend.layouts.app')

@section('content')
    <!-- start page-wrapper -->
    <div class="page-wrapper">

        <!-- start wpo-page-title -->
        <section class="wpo-page-title">
            <h2 class="d-none">{{ __('Hide') }}</h2>
            <div class="container">
                <div class="row">
                    <div class="col col-xs-12">
                        <div class="wpo-breadcumb-wrap">
                            <ol class="wpo-breadcumb-wrap">
                                <li><a href="{{ route('home.index') }}">{{ __('Home') }}</a></li>
                                <li>{{ __('Contact') }}</li>
                            </ol>
                        </div>
                    </div>
                </div> <!-- end row -->
            </div> <!-- end container -->
        </section>
        <!-- end page-title -->

        <!-- start wpo-contact-pg-section -->
        <section class="wpo-contact-pg-section section-padding">
            <div class="container">
                <div class="row">
                    <div class="col col-lg-10 offset-lg-1">
                        <div class="office-info">
                            <div class="row">
                                <div class="col col-xl-4 col-lg-6 col-md-6 col-12">
                                    <div class="office-info-item">
                                        <div class="office-info-icon">
                                            <div class="icon">
                                                <i class="fi flaticon-pin"></i>
                                            </div>
                                        </div>
                                        <div class="office-info-text">
                                            <h2>{{ __('Address') }}</h2>
                                            <p>{{ $setting->address }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col col-xl-4 col-lg-6 col-md-6 col-12">
                                    <div class="office-info-item">
                                        <div class="office-info-icon">
                                            <div class="icon">
                                                <i class="fi flaticon-mail"></i>
                                            </div>
                                        </div>
                                        <div class="office-info-text">
                                            <h2>{{ __('Email Us') }}</h2>
                                            <p>{{ $setting->email }}</p>
                                            <p>{{ $setting->email }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col col-xl-4 col-lg-6 col-md-6 col-12">
                                    <div class="office-info-item">
                                        <div class="office-info-icon">
                                            <div class="icon">
                                                <i class="fi flaticon-phone"></i>
                                            </div>
                                        </div>
                                        <div class="office-info-text">
                                            <h2>{{ __('Call Now') }}</h2>
                                            <p>{{ $setting->phone_1 }}</p>
                                            <p>{{ $setting->phone_2 }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wpo-contact-title">
                            <h2>{{ __('Have Any Question?') }}</h2>
                            <p>It is a long established fact that a reader will be distracted
                                content of a page when looking.</p>
                        </div>
                        <div class="wpo-contact-form-area">
                            {{-- Success Message --}}
                            @if (session('success'))
                                <div class="alert alert-success mt-2">
                                    {{ session('success') }}
                                </div>
                            @endif

                            {{-- Error Messages --}}
                            @if ($errors->any())
                                <div class="alert alert-danger mt-2">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('contact.store') }}" class="contact-validation-active">
                                @csrf

                                <div>
                                    <input type="text" class="form-control" name="name" id="name"
                                        value="{{ old('name') }}" placeholder="Your Name*">
                                </div>

                                <div>
                                    <input type="email" class="form-control" name="email" id="email"
                                        value="{{ old('email') }}" placeholder="Your Email*">
                                </div>

                                <div>
                                    <input type="text" class="form-control" name="adress" id="adress"
                                        value="{{ old('adress') }}" placeholder="Address">
                                </div>

                                <div>
                                    <select name="service" class="form-control">
                                        <option value="" disabled selected>Services</option>
                                        <option value="Architecture"
                                            {{ old('service') == 'Architecture' ? 'selected' : '' }}>Architecture</option>
                                        <option value="The Rehearsal Dinner"
                                            {{ old('service') == 'The Rehearsal Dinner' ? 'selected' : '' }}>The Rehearsal
                                            Dinner</option>
                                        <option value="The Afterparty"
                                            {{ old('service') == 'The Afterparty' ? 'selected' : '' }}>The Afterparty
                                        </option>
                                        <option value="Videographers"
                                            {{ old('service') == 'Videographers' ? 'selected' : '' }}>Videographers
                                        </option>
                                        <option value="Perfect Cake"
                                            {{ old('service') == 'Perfect Cake' ? 'selected' : '' }}>Perfect Cake</option>
                                        <option value="All Of The Above"
                                            {{ old('service') == 'All Of The Above' ? 'selected' : '' }}>All Of The Above
                                        </option>
                                    </select>
                                </div>

                                <div class="fullwidth">
                                    <textarea class="form-control" name="note" id="note" placeholder="Message...">{{ old('note') }}</textarea>
                                </div>

                                <div class="submit-area">
                                    <button type="submit" class="theme-btn">Get in Touch</button>
                                    <div id="loader">
                                        <i class="ti-reload"></i>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div> <!-- end container -->
        </section>
        <!-- end wpo-contact-pg-section -->

        <!--  start wpo-contact-map -->
        <section class="wpo-contact-map-section">
            <h2 class="hidden">Contact map</h2>
            <div class="wpo-contact-map">
                @if (!empty($setting->google_map_url))
                    <iframe src="{{ $setting->google_map_url }}" allowfullscreen
                        style="border:0; width:100%; height:550px;" loading="lazy"></iframe>
                @else
                    {{-- <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3651.902442430132!2d90.39108007602336!3d23.750858088751508!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b888ad33913b%3A0xf16b9ad3fe596f99!2sDhaka!5e0!3m2!1sen!2sbd!4v1710000000000!5m2!1sen!2sbd"
                        allowfullscreen style="border:0; width:100%; height:450px;" loading="lazy"></iframe> --}}
                @endif
            </div>
        </section>
        <!-- end wpo-contact-map -->
    </div>
    <!-- end of page-wrapper -->
@endsection
