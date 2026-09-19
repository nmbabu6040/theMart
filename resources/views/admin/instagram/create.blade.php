@extends('admin.layouts.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Add Instagram Post</h2>
                <a href="{{ route('instagram.index') }}" class="btn btn-secondary">Back</a>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('instagram.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Image <span class="text-danger">*</span></label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                                required>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Instagram Post Link (URL)</label>
                            <input type="url" name="post_url"
                                class="form-control @error('post_url') is-invalid @enderror"
                                placeholder="https://www.instagram.com/p/..." value="{{ old('post_url') }}">
                            @error('post_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="status" class="form-check-input" id="status" value="1"
                                checked>
                            <label class="form-check-label" for="status">Active</label>
                        </div>

                        <button type="submit" class="btn btn-primary">Save Post</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
