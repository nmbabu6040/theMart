@extends('admin.layouts.master')

@section('content')
    <div class="page-content">

        {{-- Header --}}
        <div class="category-header d-flex justify-content-between align-items-center mb-4">

            <div>
                <h3 class="mb-1">Category Trash</h3>
                <p class="text-muted mb-0">
                    Manage deleted categories
                </p>
            </div>

            <div class="d-flex gap-2">

                <a href="{{ route('categories.index') }}" class="btn btn-primary btn-sm">
                    All Categories
                </a>

                <a href="{{ route('categories.create') }}" class="btn btn-success btn-sm">
                    Add Category
                </a>

            </div>

        </div>


        {{-- Success Message --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">

                {{ session('success') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

            </div>
        @endif


        {{-- Error Message --}}
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">

                {{ session('error') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

            </div>
        @endif


        <div class="card">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <h5 class="card-title mb-0">
                        Deleted Categories
                    </h5>

                    <span class="badge bg-danger">
                        {{ $categories->total() }} Deleted
                    </span>

                </div>


                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead>

                            <tr>

                                <th class="text-center">
                                    #
                                </th>

                                <th>
                                    Category
                                </th>

                                <th class="text-center">
                                    Image
                                </th>

                                <th class="text-center">
                                    Status
                                </th>

                                <th class="text-center">
                                    Deleted At
                                </th>

                                <th class="text-center">
                                    Actions
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse ($categories as $category)
                                <tr>

                                    {{-- Serial --}}
                                    <td class="text-center">

                                        {{ $categories->firstItem() + $loop->index }}

                                    </td>


                                    {{-- Category Name --}}
                                    <td>

                                        <strong>
                                            {{ $category->name }}
                                        </strong>

                                        <br>

                                        <small class="text-muted">
                                            {{ $category->slug }}
                                        </small>

                                    </td>


                                    {{-- Image --}}
                                    <td class="text-center">

                                        @if ($category->image)
                                            <img src="{{ asset('storage/' . $category->image) }}"
                                                alt="{{ $category->name }}" width="60" height="60"
                                                style="
                                                    object-fit: cover;
                                                    border-radius: 8px;
                                                ">
                                        @else
                                            <span class="text-muted">
                                                No Image
                                            </span>
                                        @endif

                                    </td>


                                    {{-- Status --}}
                                    <td class="text-center">

                                        @if ($category->status)
                                            <span class="badge bg-success">
                                                Active
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                Inactive
                                            </span>
                                        @endif

                                    </td>


                                    {{-- Deleted At --}}
                                    <td class="text-center">

                                        <span class="text-muted">

                                            {{ $category->deleted_at?->format('d M Y, h:i A') }}

                                        </span>

                                    </td>


                                    {{-- Actions --}}
                                    <td>

                                        <div class="d-flex justify-content-center gap-2">


                                            {{-- Restore --}}
                                            <form action="{{ route('categories.restore', $category->id) }}" method="POST"
                                                class="d-inline">

                                                @csrf
                                                @method('PATCH')

                                                <button type="submit" class="btn btn-success btn-sm"
                                                    onclick="return confirm('Are you sure you want to restore this category?')">
                                                    Restore
                                                </button>

                                            </form>


                                            {{-- Permanent Delete --}}
                                            <form action="{{ route('categories.force-delete', $category->id) }}"
                                                method="POST" class="d-inline">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('WARNING! This category will be permanently deleted. This action cannot be undone. Continue?')">
                                                    Delete Permanently
                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="6" class="text-center py-5">

                                        <div class="text-muted">

                                            <h5 class="mb-2">
                                                Trash is Empty
                                            </h5>

                                            <p class="mb-3">
                                                There are no deleted categories.
                                            </p>

                                            <a href="{{ route('categories.index') }}" class="btn btn-primary btn-sm">
                                                Back to Categories
                                            </a>

                                        </div>

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- Pagination --}}
                @if ($categories->hasPages())
                    <div class="mt-4">

                        {{ $categories->links() }}

                    </div>
                @endif

            </div>

        </div>

    </div>
@endsection
