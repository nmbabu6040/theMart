@extends('admin.layouts.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <h2>Add New Slider</h2>
            <div class="card shadow col-md-8">
                <div class="card-body">
                    <form action="{{ route('sliders.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label>Slider Image *</label>
                            <input type="file" name="image" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control"
                                placeholder="Trendy & Unique Collection">
                        </div>
                        <div class="mb-3">
                            <label>Subtitle</label>
                            <input type="text" name="subtitle" class="form-control">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Button Text</label>
                                <input type="text" name="btn_text" class="form-control" value="Shop Now">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Button Link</label>
                                <input type="text" name="btn_link" class="form-control" placeholder="/shop">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Serial Number</label>
                                <input type="number" name="serial_number" class="form-control" value="1">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="d-block">Status</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="status" id="status" checked>
                                    <label class="form-check-label" for="status">Active</label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Slider</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
