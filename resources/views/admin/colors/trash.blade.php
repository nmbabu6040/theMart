@extends('admin.layouts.master')

@section('content')
    <div class="page-content">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h4 class="mb-1">Trashed Colors</h4>
                <p class="text-muted mb-0">
                    Manage deleted product colors.
                </p>
            </div>

            <a href="{{ route('colors.index') }}" class="btn btn-primary btn-sm">
                All Colors
            </a>

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

                        <thead>
                            <tr>

                                <th class="text-center" width="80">
                                    SL
                                </th>

                                <th>
                                    Color Name
                                </th>

                                <th class="text-center">
                                    Color
                                </th>

                                <th class="text-center">
                                    Code
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

                                <th class="text-center" width="240">
                                    Action
                                </th>

                            </tr>
                        </thead>


                        <tbody>

                            @forelse ($colors as $color)
                                <tr>

                                    <td class="text-center">
                                        {{ $colors->firstItem() + $loop->index }}
                                    </td>


                                    <td>
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


                                    <td class="text-center">
                                        {{ $color->deleted_at?->format('d M, Y h:i A') }}
                                    </td>


                                    <td>

                                        <div class="d-flex justify-content-center gap-2">

                                            {{-- Restore --}}
                                            <form action="{{ route('colors.restore', $color->id) }}" method="POST">

                                                @csrf
                                                @method('PATCH')

                                                <button type="submit" class="btn btn-success btn-sm">

                                                    Restore

                                                </button>

                                            </form>


                                            {{-- Permanent Delete --}}
                                            <form action="{{ route('colors.force-delete', $color->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure? This action cannot be undone.');">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger btn-sm">

                                                    Permanent Delete

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="8" class="text-center text-muted py-4">

                                        Trash is empty.

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
