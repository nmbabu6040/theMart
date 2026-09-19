@extends('admin.layouts.master')

@section('content')
    <div class="page-content">

        {{-- Header --}}
        <div class="category-header d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-1">Sub-Categories</h3>
                <p class="text-muted mb-0">Manage all sub-categories</p>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('sub-categories.trash') }}" class="btn btn-danger btn-sm">
                    Trash
                </a>

                <a href="{{ route('sub-categories.create') }}" class="btn btn-primary btn-sm">
                    Add Sub-Category
                </a>
            </div>
        </div>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        {{-- Error Message --}}
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">

                        <thead>
                            <tr>
                                <th width="60" class="text-center">#</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th width="100" class="text-center">Sort</th>
                                <th width="100" class="text-center">Status</th>
                                <th width="180" class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($subCategories as $key => $subCategory)
                                <tr>

                                    <td class="text-center">
                                        {{ $subCategories->firstItem() + $key }}
                                    </td>

                                    <td>
                                        @if ($subCategory->image)
                                            <img src="{{ asset('storage/' . $subCategory->image) }}"
                                                alt="{{ $subCategory->name }}" width="60" height="60"
                                                style="object-fit: cover;" class="rounded">
                                        @else
                                            <span class="text-muted">No Image</span>
                                        @endif
                                    </td>

                                    <td>
                                        <strong>{{ $subCategory->name }}</strong>
                                    </td>

                                    <td>
                                        {{ $subCategory->category?->name ?? 'N/A' }}
                                    </td>

                                    <td class="text-center">
                                        {{ $subCategory->sort_order }}
                                    </td>

                                    <td class="text-center">
                                        @if ($subCategory->status)
                                            <span class="badge badge-success">
                                                Active
                                            </span>
                                        @else
                                            <span class="badge badge-danger">
                                                Inactive
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="d-flex justify-content-center gap-2">

                                            <a href="{{ route('sub-categories.edit', $subCategory) }}"
                                                class="btn btn-primary btn-sm">
                                                Edit
                                            </a>

                                            <form action="{{ route('sub-categories.destroy', $subCategory) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to move this sub-category to trash?');">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    Delete
                                                </button>

                                            </form>

                                        </div>
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        No sub-category found.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>
                </div>

                {{-- Pagination --}}
                @if ($subCategories->hasPages())
                    <div class="mt-4">
                        {{ $subCategories->links() }}
                    </div>
                @endif

            </div>
        </div>

    </div>
@endsection
