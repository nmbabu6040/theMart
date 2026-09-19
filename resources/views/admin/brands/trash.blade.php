@extends('admin.layouts.master')

@section('content')
    <div class="page-content">

        {{-- Header --}}
        <div class="category-header d-flex justify-content-between align-items-center mb-4">

            <h3 class="mb-0">Brand Trash</h3>

            <div class="d-flex gap-2">

                <a href="{{ route('brands.index') }}" class="btn btn-primary btn-sm">
                    All Brands
                </a>

                <a href="{{ route('brands.create') }}" class="btn btn-success btn-sm">
                    Add Brand
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

        <div class="card">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered table-hover">

                        <thead>
                            <tr>

                                <th width="70" class="text-center">
                                    #
                                </th>

                                <th width="120" class="text-center">
                                    Image
                                </th>

                                <th>
                                    Name
                                </th>

                                <th>
                                    Slug
                                </th>

                                <th width="180" class="text-center">
                                    Deleted At
                                </th>

                                <th width="230" class="text-center">
                                    Action
                                </th>

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

                                    <td>
                                        <strong>
                                            {{ $brand->name }}
                                        </strong>
                                    </td>

                                    <td>
                                        {{ $brand->slug }}
                                    </td>

                                    <td class="text-center">

                                        {{ $brand->deleted_at->format('d M Y, h:i A') }}

                                    </td>

                                    <td class="text-center">

                                        <div class="d-flex justify-content-center gap-2">

                                            {{-- Restore --}}
                                            <form action="{{ route('brands.restore', $brand->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to restore this brand?');">

                                                @csrf
                                                @method('PATCH')

                                                <button type="submit" class="btn btn-success btn-sm">
                                                    Restore
                                                </button>

                                            </form>

                                            {{-- Permanent Delete --}}
                                            <form action="{{ route('brands.force-delete', $brand->id) }}" method="POST"
                                                onsubmit="return confirm('This will permanently delete the brand and its image. This action cannot be undone. Continue?');">

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

                                    <td colspan="6" class="text-center text-muted fw-bold py-4">

                                        Trash is empty.

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
