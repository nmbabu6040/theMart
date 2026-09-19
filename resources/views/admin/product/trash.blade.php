@extends('admin.layouts.master')

@section('content')
    <div class="page-content">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Trashed Products</h3>
            <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">
                Back to Products
            </a>
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
                                <th>Sale Price</th>
                                <th>Deleted At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if ($product->thumbnail)
                                            <img src="{{ asset($product->thumbnail) }}" alt="{{ $product->name }}"
                                                width="50" class="rounded">
                                        @else
                                            <span class="text-muted">No Image</span>
                                        @endif
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->sku }}</td>
                                    <td>{{ number_format($product->sale_price, 2) }}</td>
                                    <td>{{ $product->deleted_at?->format('d M, Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            {{-- Restore Form --}}
                                            <form action="{{ route('products.restore', $product->id) }}" method="POST"
                                                style="display:inline-block;">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-success">Restore</button>
                                            </form>

                                            {{-- Permanent Delete Form --}}
                                            <form action="{{ route('products.forceDelete', $product->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to permanently delete this item? This action cannot be undone.');"
                                                style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete
                                                    Permanently</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Trash is empty.</td>
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
