@extends('admin.layouts.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid py-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>Manage Coupons</h3>
                <a href="{{ route('coupons.create') }}" class="btn btn-primary">+ Add New Coupon</a>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>Type</th>
                                    <th>Value</th>
                                    <th>Min Cart Amount</th>
                                    <th>Validity</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($coupons as $key => $coupon)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td><strong class="text-primary">{{ $coupon->code }}</strong></td>
                                        <td><span class="badge bg-info">{{ ucfirst($coupon->type) }}</span></td>
                                        <td>
                                            {{ $coupon->type == 'percent' ? $coupon->value . '%' : '$' . number_format($coupon->value, 2) }}
                                        </td>
                                        <td>${{ number_format($coupon->min_cart_amount, 2) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($coupon->validity)->format('d M, Y') }}</td>
                                        <td>
                                            <!-- Status Toggle Form -->
                                            <form action="{{ route('coupons.toggle', $coupon->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <button type="submit"
                                                    class="btn btn-sm {{ $coupon->status ? 'btn-success' : 'btn-secondary' }}">
                                                    {{ $coupon->status ? 'Active' : 'Inactive' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <!-- Edit Button -->
                                            <a href="{{ route('coupons.edit', $coupon->id) }}"
                                                class="btn btn-sm btn-info text-white">
                                                <i class="fi ti-pencil"></i> Edit
                                            </a>

                                            <!-- Delete Button -->
                                            <form action="{{ route('coupons.destroy', $coupon->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this coupon?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No coupons found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
