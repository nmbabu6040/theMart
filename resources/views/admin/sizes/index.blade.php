@extends('admin.layouts.master')

@section('content')
    <div class="page-content">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-1">Sizes</h3>
                {{-- <p class="text-muted mb-0">Manage product sizes.</p> --}}
            </div>

            <div class=" gap-2">

                <a href="{{ route('sizes.create') }}" class="btn btn-primary btn-sm">
                    Add Size
                </a>

                <a href="{{ route('sizes.trash') }}" class="btn btn-danger btn-sm">
                    Trash
                </a>

            </div>
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

                        <thead class="table-dark">
                            <tr>
                                <th class="text-center text-white" width="80">SL</th>
                                <th class="text-center text-white">Size</th>
                                <th class="text-center text-white ">Sort Order</th>
                                <th class="text-center text-white ">Status</th>
                                <th class="text-center text-white" width="180">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($sizes as $size)
                                <tr>

                                    <td class="text-center">
                                        {{ $sizes->firstItem() + $loop->index }}
                                    </td>


                                    <td class="text-center">
                                        <strong>{{ $size->name }}</strong>
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

                                        <div class="d-flex justify-content-center gap-2">

                                            <a href="{{ route('sizes.edit', $size->id) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-edit text-white"></i>
                                            </a>


                                            <form action="{{ route('sizes.destroy', $size->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to move this size to trash?');">

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
                                    <td colspan="5" class="text-center text-muted py-4">
                                        No sizes found.
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
