@extends('admin.layouts.master')

@section('content')
    <div class="page-content">
        <div class="category-header d-flex justify-content-between align-items-center mb-4">
            <h3>All Categories</h3>
            <div class="gap-3">
                <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm">Add</a>
                <a href="{{ route('categories.trash') }}" class="btn btn-danger btn-sm">Trash</a>
            </div>
        </div>
        <div class="categories-table">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center text-white">SL</th>
                        <th class="text-center text-white">Name</th>
                        <th class="text-center text-white">Image</th>
                        <th class="text-center text-white">Status</th>
                        <th class="text-center text-white">Actions</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($categories as $category)
                        <tr>
                            <td class="text-center">
                                {{ $loop->iteration }}
                            </td>

                            <td class="text-center">
                                {{ $category->name }}
                            </td>

                            <td class="text-center">

                                @if ($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                        width="60" height="60" style="object-fit: cover;">
                                @else
                                    <span class="text-muted">
                                        No Image
                                    </span>
                                @endif

                            </td>

                            <td class="text-center">

                                @if ($category->status)
                                    <span class="badge bg-success">
                                        Active
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        Inactive
                                    </span>
                                @endif

                            </td>

                            <td class="text-center">

                                <div class="d-flex justify-content-center gap-3">

                                    {{-- Edit --}}
                                    <a href="{{ route('categories.edit', $category->id) }}"
                                        class="btn btn-primary btn-sm me-1">
                                        <i class="fa fa-edit"></i>
                                    </a>


                                    {{-- Delete --}}
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                        class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-sm "
                                            onclick="return confirm('Are you sure you want to delete this category?')">
                                            <i class="fa fa-trash"></i>
                                        </button>

                                    </form>

                                </div>

                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="text-center text-danger fw-bold py-4">
                                No category found.
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
        <div>
            {{ $categories->links() }}
        </div>
    </div>
@endsection
