@extends('admin.layouts.master')

@section('content')
    <div class="page-content">

        {{-- Header --}}
        <div class="category-header d-flex justify-content-between align-items-center mb-4">

            <h3 class="mb-0">Add Brand</h3>

            <div class="d-flex gap-2">

                <a href="{{ route('brands.index') }}" class="btn btn-primary btn-sm">
                    All Brands
                </a>

                <a href="{{ route('brands.trash') }}" class="btn btn-danger btn-sm">
                    Trash
                </a>

            </div>

        </div>

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">

            <div class="card-body">

                <form action="{{ route('brands.store') }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    <div class="row">

                        {{-- Name --}}
                        <div class="col-md-6">
                            <div class="form-group">

                                <label for="name">
                                    Brand Name
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                    placeholder="Enter brand name" required>

                                @error('name')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>
                        </div>

                        {{-- Slug --}}
                        <div class="col-md-6">
                            <div class="form-group">

                                <label for="slug">
                                    Slug
                                </label>

                                <input type="text" name="slug" id="slug"
                                    class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}"
                                    placeholder="brand-slug">

                                @error('slug')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>
                        </div>

                        {{-- Image --}}
                        <div class="col-md-6">
                            <div class="form-group">

                                <label for="image">
                                    Brand Image
                                </label>

                                <input type="file" name="image" id="image"
                                    class="form-control @error('image') is-invalid @enderror"
                                    accept=".jpg,.jpeg,.png,.webp">

                                <small class="form-text text-muted">
                                    JPG, JPEG, PNG or WEBP. Maximum 2MB.
                                </small>

                                @error('image')
                                    <span class="invalid-feedback d-block">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>
                        </div>

                        {{-- Sort Order --}}
                        <div class="col-md-3">
                            <div class="form-group">

                                <label for="sort_order">
                                    Sort Order
                                </label>

                                <input type="number" name="sort_order" id="sort_order"
                                    class="form-control @error('sort_order') is-invalid @enderror"
                                    value="{{ old('sort_order', 0) }}" min="0">

                                @error('sort_order')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="col-md-3">
                            <div class="form-group">

                                <label for="status">
                                    Status
                                </label>

                                <select name="status" id="status" class="form-control">
                                    <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>
                                        Active
                                    </option>

                                    <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>

                            </div>
                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary">
                        Save Brand
                    </button>

                    <a href="{{ route('brands.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>

                </form>

            </div>

        </div>

    </div>
@endsection
