@extends('admin.layouts.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Instagram Feeds</h2>
                <a href="{{ route('instagram.create') }}" class="btn btn-primary">Add New Post</a>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered align-middle">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Image</th>
                                <th>Post URL</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($feeds as $key => $feed)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <img src="{{ asset('storage/' . $feed->image) }}" width="70" height="70"
                                            style="object-fit: cover;" class="rounded">
                                    </td>
                                    <td>
                                        @if ($feed->post_url)
                                            <a href="{{ $feed->post_url }}"
                                                target="_blank">{{ Str::limit($feed->post_url, 40) }}</a>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $feed->status ? 'success' : 'danger' }}">
                                            {{ $feed->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('instagram.edit', $feed->id) }}"
                                            class="btn btn-sm btn-info text-white">Edit</a>
                                        <form action="{{ route('instagram.destroy', $feed->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No instagram feeds found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
