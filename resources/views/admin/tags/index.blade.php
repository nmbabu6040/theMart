@extends('admin.layouts.master')

@section('content')
    <div class="page-content">

        <div class="category-header d-flex justify-content-between align-items-center mb-4">
            <h3>Tags</h3>

            <div class="d-flex gap-2">
                <a href="{{ route('tags.create') }}" class="btn btn-primary btn-sm">
                    Add Tag
                </a>

                <a href="{{ route('tags.trash') }}" class="btn btn-danger btn-sm">
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

        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-dark">
                            <tr>
                                <th width="70" class="text-center text-white">#</th>
                                <th class="text-center text-white">Tag Name</th>
                                <th class="text-center text-white">Slug</th>
                                <th width="120" class="text-center text-white">Sort Order</th>
                                <th width="120" class="text-center text-white">Status</th>
                                <th width="180" class="text-center text-white">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($tags as $tag)
                                <tr>
                                    <td class="text-center">
                                        {{ $tags->firstItem() + $loop->index }}
                                    </td>

                                    <td class="text-center">
                                        {{ $tag->name }}
                                    </td>

                                    <td class="text-center">
                                        {{ $tag->slug }}
                                    </td>

                                    <td class="text-center">
                                        {{ $tag->sort_order }}
                                    </td>

                                    <td class="text-center">

                                        @if ($tag->status)
                                            <span class="badge badge-success">
                                                Active
                                            </span>
                                        @else
                                            <span class="badge badge-secondary">
                                                Inactive
                                            </span>
                                        @endif

                                    </td>

                                    <td class="text-center">

                                        <div class="d-flex justify-content-center gap-2">

                                            <a href="{{ route('tags.edit', $tag) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-edit text-white"></i>
                                            </a>

                                            <form action="{{ route('tags.destroy', $tag) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to move this tag to trash?');">

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
                                    <td colspan="6" class="text-center text-danger fw-bold py-4">
                                        No tag found.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>
                </div>

                @if ($tags->hasPages())
                    <div class="mt-4">
                        {{ $tags->links() }}
                    </div>
                @endif

            </div>
        </div>

    </div>
@endsection
