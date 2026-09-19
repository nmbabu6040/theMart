@extends('admin.layouts.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Edit Instagram Post</h2>
                <a href="{{ route('instagram.index') }}" class="btn btn-secondary">Back</a>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('instagram.update', $instagram->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Current Image</label>
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $instagram->image) }}" width="100" class="rounded">
                            </div>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Instagram Post Link (URL)</label>
                            <input type="url" name="post_url"
                                class="form-control @error('post_url') is-invalid @enderror"
                                value="{{ old('post_url', $instagram->post_url) }}">
                            @error('post_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="status" class="form-check-input" id="status" value="1"
                                {{ $instagram->status ? 'checked' : '' }}>
                            <label class="form-check-label" for="status">Active</label>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Post</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
