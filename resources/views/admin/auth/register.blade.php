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

                                <div class="col-md-4 pr-md-0">
                                    <div class="auth-left-wrapper"></div>
                                </div>

                                <div class="col-md-8 pl-md-0">

                                    <div class="auth-form-wrapper px-4 py-5">

                                        <a href="{{ url('/') }}" class="noble-ui-logo d-block mb-2">
                                            Noble<span>UI</span>
                                        </a>

                                        <h5 class="text-muted font-weight-normal mb-4">
                                            Create a free account.
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

                                        {{-- Success Message --}}
                                        @if (session('success'))
                                            <div class="alert alert-success">
                                                {{ session('success') }}
                                            </div>
                                        @endif

                                        <form class="forms-sample" method="POST"
                                            action="{{ route('auth.register.store') }}">

                                            @csrf

                                            {{-- Name --}}
                                            <div class="form-group">
                                                <label for="name">
                                                    Name
                                                </label>

                                                <input type="text"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    id="name" name="name" value="{{ old('name') }}"
                                                    autocomplete="name" placeholder="Enter your name" required>

                                                @error('name')
                                                    <span class="invalid-feedback">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>


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
                                                    id="password" name="password" autocomplete="new-password"
                                                    placeholder="Enter password" required>

                                                @error('password')
                                                    <span class="invalid-feedback">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>


                                            {{-- Confirm Password --}}
                                            <div class="form-group">
                                                <label for="password_confirmation">
                                                    Confirm Password
                                                </label>

                                                <input type="password" class="form-control" id="password_confirmation"
                                                    name="password_confirmation" autocomplete="new-password"
                                                    placeholder="Confirm password" required>
                                            </div>


                                            {{-- Remember --}}
                                            <div class="form-check form-check-flat form-check-primary">

                                                <label class="form-check-label">

                                                    <input type="checkbox" class="form-check-input" name="remember"
                                                        value="1">

                                                    Remember me

                                                </label>

                                            </div>


                                            {{-- Submit --}}
                                            <div class="mt-3">

                                                <button type="submit"
                                                    class="btn btn-primary text-white mr-2 mb-2 mb-md-0">
                                                    Sign up
                                                </button>

                                                <a href="{{ route('auth.login') }}"
                                                    class="btn btn-outline-primary mb-2 mb-md-0">
                                                    Sign in
                                                </a>

                                            </div>


                                            <a href="{{ route('auth.login') }}" class="d-block mt-3 text-muted">
                                                Already a user? Sign in
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
