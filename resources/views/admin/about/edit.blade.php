@extends('admin.layouts.master') {{-- আপনার অ্যাডমিন লেআউট অনুযায়ী পরিবর্তন করুন --}}

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit About Us Section</h4>
                        </div>
                        <div class="card-body">

                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            <form action="{{ route('about.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group mb-3">
                                    <label>Sub Title</label>
                                    <input type="text" name="sub_title" class="form-control"
                                        value="{{ old('sub_title', $about->sub_title ?? '') }}" placeholder="e.g. ABOUT US">
                                </div>

                                <div class="form-group mb-3">
                                    <label>Title (HTML Allowed: &lt;b&gt;, &lt;span&gt;)</label>
                                    <input type="text" name="title" class="form-control"
                                        value="{{ old('title', $about->title ?? '') }}"
                                        placeholder="We Help Your <b>Digital<span>&</span>Business Grow.</b>">
                                </div>

                                <div class="form-group mb-3">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control" rows="5">{{ old('description', $about->description ?? '') }}</textarea>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Current Image</label><br>
                                    @if (isset($about->image))
                                        <img src="{{ asset($about->image) }}" alt="About Image" width="120"
                                            class="mb-2 rounded">
                                    @else
                                        <p class="text-muted">No image uploaded yet</p>
                                    @endif
                                    <br>
                                    <label>Upload New Image</label>
                                    <input type="file" name="image" class="form-control">
                                </div>

                                <button type="submit" class="btn btn-primary">Update About Section</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
