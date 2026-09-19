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
                                <li>{{ __('FAQ') }}</li>
                            </ol>
                        </div>
                    </div>
                </div> <!-- end row -->
            </div> <!-- end container -->
        </section>
        <!-- end page-title -->

        <!-- start wpo-faq-section -->
        <section class="wpo-faq-section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-8 offset-lg-2">
                        <div class="wpo-section-title">
                            <h2>{{ __('Frequently Asked Question') }}</h2>
                        </div>
                    </div>
                    <div class="col-lg-8 offset-lg-2">
                        <div class="wpo-faq-wrap">
                            <div class="row">
                                <div class="col-lg-12 col-12">
                                    <div class="wpo-benefits-item">
                                        <div class="accordion" id="accordionExample">
                                            @foreach ($faqs as $index => $faq)
                                                <div class="accordion-item">
                                                    <h3 class="accordion-header" id="headingOne">
                                                        <button class="accordion-button" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapse{{ $faq->id }}"
                                                            aria-expanded="{{ $index == 0 ? 'true' : 'false' }}"
                                                            aria-controls="collapse{{ $faq->id }}">
                                                            {{ $faq->question }}
                                                        </button>
                                                    </h3>
                                                    <div id="collapse{{ $faq->id }}"
                                                        class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}"
                                                        aria-labelledby="heading{{ $faq->id }}"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <p>{!! nl2br(e($faq->answer)) !!}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end container -->
        </section>
        <!-- end faq-section -->

        <div class="question-area section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="wpo-section-title">
                            <h2>{{ __('Do You Have Any Question?') }}</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="question-touch">
                            <h2>{{ __('Get In Touch') }}</h2>

                            @if (session('success'))
                                <div class="alert alert-success mt-2">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form action="{{ route('contact.store') }}" method="POST">
                                @csrf
                                <div class="half-col">
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="{{ __('Your Name') }}" value="{{ old('name') }}" required>
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="half-col">
                                    <input type="email" name="email" id="email" class="form-control"
                                        placeholder="{{ __('Email Address') }}" value="{{ old('email') }}" required>
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="half-col">
                                    <input type="text" name="subject" id="subject" class="form-control"
                                        placeholder="{{ __('Subject') }}" value="{{ old('subject') }}">
                                </div>
                                <div>
                                    <textarea class="form-control" name="note" id="note" placeholder="{{ __('Your Question') }}" required>{{ old('note') }}</textarea>
                                    @error('note')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="submit-btn-wrapper">
                                    <button type="submit" class="theme-btn color-9">{{ __('Submit Now') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end of page-wrapper -->
@endsection
