@extends('admin.layouts.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <!-- Upload Image -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Upload Gallery Image</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label>Caption / Title (Optional)</label>
                                    <input type="text" name="title" class="form-control" placeholder="Image Title">
                                </div>
                                <div class="mb-3">
                                    <label>Select Image</label>
                                    <input type="file" name="image" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Gallery Grid List -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Gallery List</h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            <div class="row">
                                @forelse($galleries as $gallery)
                                    <div class="col-md-3 col-6 mb-3 text-center">
                                        <div class="border p-2 rounded">
                                            <img src="{{ asset($gallery->image) }}" class="img-fluid rounded mb-2"
                                                style="height: 100px; object-fit: cover;">
                                            <form action="{{ route('gallery.destroy', $gallery->id) }}" method="POST"
                                                onsubmit="return confirm('Delete this image?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm w-100">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12 text-center">
                                        <p>No images in gallery.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
