@extends('admin.layouts.master') {{-- আপনার Admin Layout পাথ অনুযায়ী দিন --}}

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Sliders List</h2>
                <a href="{{ route('sliders.create') }}" class="btn btn-primary">Add New Slider</a>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card shadow mb-4">
                <div class="card-body">
                    <table class="table table-bordered align-middle">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Button Link</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sliders as $slider)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <img src="{{ asset('storage/' . $slider->image) }}" width="100" height="50"
                                            style="object-fit:cover;">
                                    </td>
                                    <td>{{ $slider->title ?? 'N/A' }}</td>
                                    <td>{{ $slider->btn_link ?? '#' }}</td>
                                    <td>
                                        <span class="badge {{ $slider->status ? 'bg-success' : 'bg-danger' }}">
                                            {{ $slider->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('sliders.edit', $slider->id) }}"
                                            class="btn btn-sm btn-info">Edit</a>
                                        <form action="{{ route('sliders.destroy', $slider->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No Sliders Found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
