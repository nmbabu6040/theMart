@extends('admin.layouts.master')

@section('content')
    <div class="page-content">

        {{-- Header --}}
        <div class="category-header d-flex justify-content-between align-items-center mb-4">

            <h3>All Countries</h3>

            <div class="gap-2">
                <a href="{{ route('countries.create') }}" class="btn btn-primary btn-sm">
                    Add Country
                </a>
            </div>

        </div>


        {{-- Success Message --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif


        {{-- Error Message --}}
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif


        <div class="card">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle">

                        <thead>
                            <tr>
                                <th width="80">#</th>
                                <th>Country Name</th>
                                <th>Country Code</th>
                                <th width="180">Created At</th>
                                <th width="180">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($countries as $country)
                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>
                                        <strong>
                                            {{ $country->name }}
                                        </strong>
                                    </td>

                                    <td>
                                        @if ($country->code)
                                            <span class="badge bg-secondary">
                                                {{ strtoupper($country->code) }}
                                            </span>
                                        @else
                                            <span class="text-muted">
                                                N/A
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        {{ $country->created_at?->format('d M Y') }}
                                    </td>

                                    <td>

                                        <a href="{{ route('countries.edit', $country->id) }}"
                                            class="btn btn-primary btn-sm">
                                            Edit
                                        </a>

                                        <form action="{{ route('countries.destroy', $country->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this country?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm">
                                                Delete
                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="5" class="text-center py-4">

                                        <span class="text-muted">
                                            No country found.
                                        </span>

                                        <div class="mt-2">
                                            <a href="{{ route('countries.create') }}" class="btn btn-primary btn-sm">
                                                Add First Country
                                            </a>
                                        </div>

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>
@endsection
