@extends('admin.layouts.master')

@section('content')
    <div class="page-content">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-1">Colors</h3>
                {{-- <p class="text-muted mb-0">Manage product colors.</p> --}}
            </div>

            <div class="gap-2">
                <a href="{{ route('colors.trash') }}" class="btn btn-danger btn-sm">
                    Trash
                </a>

                <a href="{{ route('colors.create') }}" class="btn btn-primary btn-sm">
                    Add Color
                </a>
            </div>
        </div>


        {{-- Success Message --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}

                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
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
                                <th class="text-center text-white">Color Name</th>
                                <th class="text-center text-white">Color</th>
                                <th class="text-center text-white">Code</th>
                                <th class="text-center text-white">Sort Order</th>
                                <th class="text-center text-white">Status</th>
                                <th class="text-center text-white" width="180">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($colors as $color)
                                <tr>

                                    <td class="text-center">
                                        {{ $colors->firstItem() + $loop->index }}
                                    </td>

                                    <td class="text-center">
                                        <strong>{{ $color->name }}</strong>
                                    </td>

                                    <td class="text-center">
                                        <span
                                            style="
                                                display: inline-block;
                                                width: 30px;
                                                height: 30px;
                                                border-radius: 50%;
                                                background-color: {{ $color->code }};
                                                border: 1px solid #ddd;
                                            ">
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <code>{{ $color->code }}</code>
                                    </td>

                                    <td class="text-center">
                                        {{ $color->sort_order }}
                                    </td>

                                    <td class="text-center">
                                        @if ($color->status)
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

                                            <a href="{{ route('colors.edit', $color->id) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-edit text-white"></i>
                                            </a>

                                            <form action="{{ route('colors.destroy', $color->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to move this color to trash?');">

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
                                    <td colspan="7" class="text-center text-muted py-4">
                                        No colors found.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>


                @if ($colors->hasPages())
                    <div class="mt-4">
                        {{ $colors->links() }}
                    </div>
                @endif

            </div>
        </div>

    </div>
@endsection
