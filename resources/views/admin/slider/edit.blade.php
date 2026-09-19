@extends('admin.layouts.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <h2>Edit Slider</h2>
            <div class="card shadow col-md-8">
                <div class="card-body">
                    <form action="{{ route('sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label>Current Image</label><br>
                            <img src="{{ asset('storage/' . $slider->image) }}" width="150" class="mb-2">
                            <input type="file" name="image" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" value="{{ $slider->title }}">
                        </div>
                        <div class="mb-3">
                            <label>Subtitle</label>
                            <input type="text" name="subtitle" class="form-control" value="{{ $slider->subtitle }}">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Button Text</label>
                                <input type="text" name="btn_text" class="form-control" value="{{ $slider->btn_text }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Button Link</label>
                                <input type="text" name="btn_link" class="form-control" value="{{ $slider->btn_link }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Serial Number</label>
                                <input type="number" name="serial_number" class="form-control"
                                    value="{{ $slider->serial_number }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="d-block">Status</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="status" id="status"
                                        {{ $slider->status ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status">Active</label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Slider</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
