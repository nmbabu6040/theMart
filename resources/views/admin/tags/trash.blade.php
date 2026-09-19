@extends('admin.layouts.master')

@section('content')
    <div class="page-content">

        <div class="category-header d-flex justify-content-between align-items-center mb-4">

            <h3>Tag Trash</h3>

            <div class="d-flex gap-2">

                <a href="{{ route('tags.index') }}" class="btn btn-primary btn-sm">
                    All Tags
                </a>

                <a href="{{ route('tags.create') }}" class="btn btn-success btn-sm">
                    Add Tag
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

                                <th>
                                    Tag Name
                                </th>

                                <th>
                                    Slug
                                </th>

                                <th width="120" class="text-center">
                                    Sort Order
                                </th>

                                <th width="120" class="text-center">
                                    Status
                                </th>

                                <th width="220" class="text-center">
                                    Deleted At
                                </th>

                                <th width="220" class="text-center">
                                    Action
                                </th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($tags as $tag)
                                <tr>

                                    <td class="text-center">
                                        {{ $tags->firstItem() + $loop->index }}
                                    </td>

                                    <td>
                                        {{ $tag->name }}
                                    </td>

                                    <td>
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
                                        {{ $tag->deleted_at?->format('d M Y, h:i A') }}
                                    </td>

                                    <td>

                                        <div class="d-flex justify-content-center gap-2">

                                            {{-- Restore --}}
                                            <a href="{{ route('tags.restore', $tag->id) }}" class="btn btn-success btn-sm"
                                                onclick="return confirm('Are you sure you want to restore this tag?');">

                                                Restore

                                            </a>

                                            {{-- Permanent Delete --}}
                                            <form action="{{ route('tags.force-delete', $tag->id) }}" method="POST"
                                                onsubmit="return confirm('This tag will be permanently deleted. This action cannot be undone. Continue?');">

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
                                    <td colspan="7" class="text-center text-danger fw-bold py-4">

                                        Trash is empty.

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
