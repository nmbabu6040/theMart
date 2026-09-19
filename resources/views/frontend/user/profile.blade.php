@extends('frontend.layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">

                {{-- Success Alert --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        <i class="ti-check-box me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="mb-0 text-white fw-bold"><i class="ti-user me-2"></i> My Profile</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- Profile Image Preview & Upload --}}
                            <div class="mb-4 text-center">
                                <div class="mb-2">
                                    @if (!empty($user->image) && file_exists(public_path('uploads/profile/' . $user->image)))
                                        <img src="{{ asset('uploads/profile/' . $user->image) }}" alt="Profile Image"
                                            class="rounded-circle img-thumbnail"
                                            style="width: 120px; height: 120px; object-fit: cover;">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0D6EFD&color=fff&size=128"
                                            alt="Default Avatar" class="rounded-circle img-thumbnail"
                                            style="width: 120px; height: 120px; object-fit: cover;">
                                    @endif
                                </div>
                                <div class="col-md-6 mx-auto">
                                    <label for="image" class="form-label small text-muted">Change Profile Picture</label>
                                    <input type="file"
                                        class="form-control form-control-sm @error('image') is-invalid @enderror"
                                        id="image" name="image" accept="image/*">
                                    @error('image')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <hr class="my-4">

                            {{-- Name --}}
                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">Full Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">Email Address <span
                                        class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Phone --}}
                            <div class="mb-3">
                                <label for="phone" class="form-label fw-bold">Phone Number</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" value="{{ old('phone', $user->phone ?? '') }}"
                                    placeholder="+8801XXXXXXXXX">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Address --}}
                            <div class="mb-4">
                                <label for="address" class="form-label fw-bold">Shipping Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3"
                                    placeholder="Enter your full shipping address">{{ old('address', $user->address ?? '') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr class="my-4">

                            <h6 class="fw-bold mb-3 text-dark"><i class="ti-lock me-1"></i> Change Password (Optional)</h6>

                            {{-- Current Password --}}
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                    id="current_password" name="current_password" placeholder="Leave blank if not changing">
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- New Password --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">New Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" placeholder="New password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" placeholder="Confirm new password">
                                </div>
                            </div>

                            {{-- Submit Button --}}
                            <div class="mt-4 text-end">
                                <button type="submit" class="btn btn-primary px-4 py-2 fw-bold">
                                    Update Profile
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
