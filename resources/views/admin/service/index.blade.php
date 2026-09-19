@extends('admin.layouts.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <!-- Add Service Form -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Add New Service</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('service.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label>Service Title</label>
                                    <input type="text" name="title" class="form-control" required
                                        placeholder="e.g. Free Shipping">
                                </div>
                                <div class="mb-3">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control" rows="3" placeholder="Free Shipping World Wide."></textarea>
                                </div>
                                <div class="mb-3">
                                    <label>Icon/Image</label>
                                    <input type="file" name="image" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Save Service</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Service List -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>All Services</h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($services as $service)
                                        <tr>
                                            <td><img src="{{ asset($service->image) }}" width="50" alt=""></td>
                                            <td>{{ $service->title }}</td>
                                            <td>{{ $service->description }}</td>
                                            <td>
                                                <form action="{{ route('service.destroy', $service->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No services found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
