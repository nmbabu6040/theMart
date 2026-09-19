@extends('admin.layouts.master')

@section('content')
    <div class="page-content">
        <div class="container py-4">
            <div class="card col-md-8 mx-auto">
                <div class="card-header">
                    <h4>Add New Coupon</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('coupons.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Coupon Code</label>
                            <input type="text" name="code" class="form-control" placeholder="e.g. SAVE20"
                                style="text-transform:uppercase;" required>
                            @error('code')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Discount Type</label>
                                <select name="type" class="form-select" required>
                                    <option value="percent">Percentage (%)</option>
                                    <option value="fixed">Fixed Amount ($)</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Discount Value</label>
                                <input type="number" step="0.01" name="value" class="form-control"
                                    placeholder="e.g. 20 or 50.00" required>
                                @error('value')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Minimum Cart Amount ($)</label>
                                <input type="number" step="0.01" name="min_cart_amount" class="form-control"
                                    value="0" placeholder="0 for no minimum">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Validity (Expire Date)</label>
                                <input type="date" name="validity" class="form-control" required>
                                @error('validity')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Save Coupon</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
