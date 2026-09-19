@extends('admin.layouts.master')

@section('content')
    <div class="page-content">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Product List</h3>
            <div>
                <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm">
                    Add Product
                </a>
                <a href="{{ route('products.trash') }}" class="btn btn-warning btn-sm">
                    Trash Bin
                </a>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Thumbnail</th>
                                <th>Name</th>
                                <th>SKU</th>
                                <th>Category</th>
                                <th>Sale Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr>
                                    <td>{{ $products->firstItem() + $loop->index }}</td>
                                    <td>
                                        @if ($product->thumbnail)
                                            <img src="{{ asset('storage/' . $product->thumbnail) }}"
                                                alt="{{ $product->name }}" width="50" class="rounded">
                                        @else
                                            <span class="text-muted">No Image</span>
                                        @endif
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->sku }}</td>
                                    <td>{{ $product->category->name ?? 'N/A' }}</td>
                                    <td>{{ number_format($product->sale_price, 2) }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>
                                        @if ($product->status)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('products.edit', $product->id) }}"
                                                class="btn btn-sm btn-info text-white">
                                                Edit
                                            </a>
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to move this item to trash?');"
                                                style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Trash</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted">No products found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if (method_exists($products, 'links'))
                    <div class="d-flex justify-content-end mt-3">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection
