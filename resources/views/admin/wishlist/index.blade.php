@extends('admin.layouts.master')

@section('content')
    <div class="page-content">
        <div class="container py-5">
            <h2>My Wishlist</h2>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($wishlists as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-4">
                                        <img src="{{ asset('storage/' . $item->product->thumbnail) }}" alt="Product"
                                            width="60" class="me-3">
                                        <h5>{{ $item->product->name }}</h5>
                                    </div>
                                </td>
                                <td>${{ number_format($item->product->sale_price, 2) }}</td>
                                <td>
                                    <form action="{{ route('wishlist.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4">Your wishlist is empty.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
