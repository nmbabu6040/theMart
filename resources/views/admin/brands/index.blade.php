@extends('admin.layouts.master')

@section('content')
    <div class="page-content">

        {{-- Header --}}
        <div class="category-header d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">All Brands</h3>

            <div class="d-flex gap-2">
                <a href="{{ route('brands.create') }}" class="btn btn-primary btn-sm">
                    Add Brand
                </a>

                <a href="{{ route('brands.trash') }}" class="btn btn-danger btn-sm">
                    Trash
                </a>
            </div>
        </div>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        {{-- Validation Error --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-dark">
                            <tr>
                                <th width="70" class="text-center text-white">#</th>
                                <th width="120" class="text-center text-white">Image</th>
                                <th class="text-center text-white">Name</th>
                                <th class="text-center text-white">Slug</th>
                                <th width="100" class="text-center text-white">Order</th>
                                <th width="100" class="text-center text-white">Status</th>
                                <th width="180" class="text-center text-white">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($brands as $brand)
                                <tr>

                                    <td class="text-center">
                                        {{ $brands->firstItem() + $loop->index }}
                                    </td>

                                    <td class="text-center">
                                        @if ($brand->image)
                                            <img src="{{ asset('storage/' . $brand->image) }}" alt="{{ $brand->name }}"
                                                width="60" height="60"
                                                style="object-fit: cover; border-radius: 6px;">
                                        @else
                                            <span class="text-muted">
                                                No Image
                                            </span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <strong>{{ $brand->name }}</strong>
                                    </td>

                                    <td class="text-center">
                                        {{ $brand->slug }}
                                    </td>

                                    <td class="text-center">
                                        {{ $brand->sort_order }}
                                    </td>

                                    <td class="text-center">

                                        @if ($brand->status)
                                            <span class="badge badge-success">
                                                Active
                                            </span>
                                        @else
                                            <span class="badge badge-danger">
                                                Inactive
                                            </span>
                                        @endif

                                    </td>

                                    <td class="text-center">

                                        <div class="d-flex justify-content-center gap-2">

                                            <a href="{{ route('brands.edit', $brand) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-edit text-white"></i>
                                            </a>

                                            <form action="{{ route('brands.destroy', $brand) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to move this brand to trash?');">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash text-white"></i>
                                                </button>
                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="7" class="text-center text-danger fw-bold py-4">
                                        No brand found.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>
                </div>

                {{-- Pagination --}}
                @if ($brands->hasPages())
                    <div class="mt-4">
                        {{ $brands->links() }}
                    </div>
                @endif

            </div>
        </div>

    </div>
@endsection
