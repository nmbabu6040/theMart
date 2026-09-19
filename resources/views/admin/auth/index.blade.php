<!DOCTYPE html>
<html lang="en">

@include('admin.layouts.head')

<body>

    <div class="main-wrapper">
        <div class="page-wrapper full-page">
            <div class="page-content d-flex align-items-center justify-content-center">

                <div class="row w-100 mx-0 auth-page">
                    <div class="col-md-8 col-xl-6 mx-auto">

                        <div class="card">
                            <div class="row">

                                <div class="col-md-12 pl-md-0">

                                    <div class="auth-form-wrapper px-4 py-5">

                                        {{-- Logo --}}
                                        <a href="{{ route('home.index') }}" class="noble-ui-logo d-block mb-2">
                                            Noble<span>UI</span>
                                        </a>

                                        <h5 class="text-muted font-weight-normal mb-4">
                                            Welcome back! Log in to your account.
                                        </h5>


                                        {{-- Validation Errors --}}
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul class="mb-0">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif


                                        {{-- Status Message --}}
                                        @if (session('status'))
                                            <div class="alert alert-danger">
                                                {{ session('status') }}
                                            </div>
                                        @endif


                                        {{-- Login Form --}}
                                        <form class="forms-sample" method="POST" action="{{ route('auth.store') }}">

                                            @csrf


                                            {{-- Email --}}
                                            <div class="form-group">

                                                <label for="email">
                                                    Email address
                                                </label>

                                                <input type="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    id="email" name="email" value="{{ old('email') }}"
                                                    autocomplete="email" placeholder="Enter your email" required>

                                                @error('email')
                                                    <span class="invalid-feedback">
                                                        {{ $message }}
                                                    </span>
                                                @enderror

                                            </div>


                                            {{-- Password --}}
                                            <div class="form-group">

                                                <label for="password">
                                                    Password
                                                </label>

                                                <input type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    id="password" name="password" autocomplete="current-password"
                                                    placeholder="Enter your password" required>

                                                @error('password')
                                                    <span class="invalid-feedback">
                                                        {{ $message }}
                                                    </span>
                                                @enderror

                                            </div>


                                            {{-- Remember Me --}}
                                            <div class="form-check form-check-flat form-check-primary">

                                                <label class="form-check-label">

                                                    <input type="checkbox" class="form-check-input" name="remember"
                                                        value="1">

                                                    Remember me

                                                </label>

                                            </div>


                                            {{-- Login Button --}}
                                            <div class="mt-3">

                                                <button type="submit"
                                                    class="btn btn-primary mr-2 mb-2 mb-md-0 text-white">
                                                    Login
                                                </button>

                                                <button type="button"
                                                    class="btn btn-outline-primary btn-icon-text mb-2 mb-md-0">
                                                    <i class="btn-icon-prepend" data-feather="twitter"></i>

                                                    Login with Twitter
                                                </button>

                                            </div>


                                            {{-- Register Link --}}
                                            <a href="{{ route('auth.register') }}" class="d-block mt-3 text-muted">
                                                Not a user? Sign up
                                            </a>

                                        </form>

                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    @include('admin.layouts.scripts')

</body>

</html>
