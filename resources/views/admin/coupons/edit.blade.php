@extends('admin.layouts.master')

@section('content')
    <div class="page-content">
        <div class="container py-4">
            <div class="card col-md-8 mx-auto">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Edit Coupon</h4>
                    <a href="{{ route('coupons.index') }}" class="btn btn-secondary btn-sm">Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('coupons.update', $coupon->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Coupon Code</label>
                            <input type="text" name="code" class="form-control"
                                value="{{ old('code', $coupon->code) }}" style="text-transform:uppercase;" required>
                            @error('code')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Discount Type</label>
                                <select name="type" class="form-select" required>
                                    <option value="percent" {{ $coupon->type == 'percent' ? 'selected' : '' }}>Percentage
                                        (%)</option>
                                    <option value="fixed" {{ $coupon->type == 'fixed' ? 'selected' : '' }}>Fixed Amount ($)
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Discount Value</label>
                                <input type="number" step="0.01" name="value" class="form-control"
                                    value="{{ old('value', $coupon->value) }}" required>
                                @error('value')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Minimum Cart Amount ($)</label>
                                <input type="number" step="0.01" name="min_cart_amount" class="form-control"
                                    value="{{ old('min_cart_amount', $coupon->min_cart_amount) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Validity (Expire Date)</label>
                                <input type="date" name="validity" class="form-control"
                                    value="{{ old('validity', $coupon->validity) }}" required>
                                @error('validity')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="1" {{ $coupon->status == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $coupon->status == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Update Coupon</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
