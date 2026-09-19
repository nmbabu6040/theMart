@extends('admin.layouts.master')

@section('content')
    <div class="page-content">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h4 class="mb-1">Trashed Sizes</h4>
                <p class="text-muted mb-0">
                    Manage deleted product sizes.
                </p>
            </div>


            <a href="{{ route('sizes.index') }}" class="btn btn-primary btn-sm">
                All Sizes
            </a>

        </div>


        {{-- Success Message --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">

                {{ session('success') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button>

            </div>
        @endif


        <div class="card">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead>

                            <tr>

                                <th class="text-center" width="80">
                                    SL
                                </th>

                                <th>
                                    Size
                                </th>

                                <th class="text-center">
                                    Sort Order
                                </th>

                                <th class="text-center">
                                    Status
                                </th>

                                <th class="text-center">
                                    Deleted At
                                </th>

                                <th class="text-center" width="220">
                                    Action
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse ($sizes as $size)
                                <tr>

                                    <td class="text-center">

                                        {{ $sizes->firstItem() + $loop->index }}

                                    </td>


                                    <td>

                                        <strong>
                                            {{ $size->name }}
                                        </strong>

                                    </td>


                                    <td class="text-center">

                                        {{ $size->sort_order }}

                                    </td>


                                    <td class="text-center">

                                        @if ($size->status)
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

                                        {{ $size->deleted_at?->format('d M, Y h:i A') }}

                                    </td>


                                    <td class="text-center">

                                        <div class="d-flex justify-content-center gap-2">

                                            {{-- Restore --}}
                                            <form action="{{ route('sizes.restore', $size->id) }}" method="POST">

                                                @csrf
                                                @method('PATCH')

                                                <button type="submit" class="btn btn-success btn-sm">

                                                    Restore

                                                </button>

                                            </form>


                                            {{-- Permanent Delete --}}
                                            <form action="{{ route('sizes.force-delete', $size->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure? This action cannot be undone.');">

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
                @if ($sizes->hasPages())
                    <div class="mt-4">

                        {{ $sizes->links() }}

                    </div>
                @endif

            </div>

        </div>

    </div>
@endsection
