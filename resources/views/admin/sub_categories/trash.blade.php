@extends('admin.layouts.master')

@section('content')
    <div class="page-content">

        {{-- Header --}}
        <div class="category-header d-flex justify-content-between align-items-center mb-4">

            <div>
                <h3 class="mb-1">Sub-Category Trash</h3>
                <p class="text-muted mb-0">
                    Manage deleted sub-categories
                </p>
            </div>

            <div>
                <a href="{{ route('sub-categories.index') }}" class="btn btn-primary btn-sm">
                    All Sub-Categories
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

                    <table class="table table-bordered table-hover">

                        <thead>
                            <tr>

                                <th width="60" class="text-center">
                                    #
                                </th>

                                <th>
                                    Image
                                </th>

                                <th>
                                    Name
                                </th>

                                <th>
                                    Category
                                </th>

                                <th>
                                    Deleted At
                                </th>

                                <th width="230" class="text-center">
                                    Action
                                </th>

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
                                            <span class="text-muted">
                                                No Image
                                            </span>
                                        @endif

                                    </td>


                                    <td>
                                        <strong>
                                            {{ $subCategory->name }}
                                        </strong>
                                    </td>


                                    <td>
                                        {{ $subCategory->category?->name ?? 'N/A' }}
                                    </td>


                                    <td>
                                        {{ $subCategory->deleted_at?->format('d M Y, h:i A') }}
                                    </td>


                                    <td>

                                        <div class="d-flex justify-content-center gap-2">

                                            {{-- Restore --}}
                                            <form action="{{ route('sub-categories.restore', $subCategory->id) }}"
                                                method="POST">

                                                @csrf
                                                @method('PATCH')

                                                <button type="submit" class="btn btn-success btn-sm">

                                                    Restore

                                                </button>

                                            </form>


                                            {{-- Force Delete --}}
                                            <form action="{{ route('sub-categories.force-delete', $subCategory->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('This will permanently delete the sub-category. Continue?');">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger btn-sm">

                                                    Delete Permanently

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="6" class="text-center text-muted py-4">

                                        Trash is empty.

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
