@extends('admin.layouts.master')

@section('content')
    <div class="page-content">

        <div class="category-header d-flex justify-content-between align-items-center mb-4">

            <div>
                <h3 class="mb-1">Edit Sub-Category</h3>
                <p class="text-muted mb-0">Update sub-category information</p>
            </div>

            <div class="d-flex gap-2">

                <a href="{{ route('sub-categories.index') }}" class="btn btn-primary btn-sm">
                    All
                </a>

                <a href="{{ route('sub-categories.trash') }}" class="btn btn-danger btn-sm">
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

                <form action="{{ route('sub-categories.update', $subCategory) }}" method="POST"
                    enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <div class="row">

                        {{-- Category --}}
                        <div class="col-md-6">
                            <div class="form-group">

                                <label for="category_id">
                                    Category <span class="text-danger">*</span>
                                </label>

                                <select name="category_id" id="category_id"
                                    class="form-control @error('category_id') is-invalid @enderror">

                                    <option value="">
                                        Select Category
                                    </option>

                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', $subCategory->category_id) == $category->id ? 'selected' : '' }}>

                                            {{ $category->name }}

                                        </option>
                                    @endforeach

                                </select>

                                @error('category_id')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>
                        </div>


                        {{-- Name --}}
                        <div class="col-md-6">
                            <div class="form-group">

                                <label for="name">
                                    Name <span class="text-danger">*</span>
                                </label>

                                <input type="text" name="name" id="name"
                                    value="{{ old('name', $subCategory->name) }}"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Sub-Category Name">

                                @error('name')
                                    <span class="text-danger">
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
                                    value="{{ old('slug', $subCategory->slug) }}"
                                    class="form-control @error('slug') is-invalid @enderror"
                                    placeholder="sub-category-slug">

                                @error('slug')
                                    <span class="text-danger">
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
                                    value="{{ old('sort_order', $subCategory->sort_order) }}" min="0"
                                    class="form-control @error('sort_order') is-invalid @enderror">

                                @error('sort_order')
                                    <span class="text-danger">
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

                                    <option value="1"
                                        {{ old('status', $subCategory->status ? '1' : '0') == '1' ? 'selected' : '' }}>
                                        Active
                                    </option>

                                    <option value="0"
                                        {{ old('status', $subCategory->status ? '1' : '0') == '0' ? 'selected' : '' }}>
                                        Inactive
                                    </option>

                                </select>

                            </div>
                        </div>


                        {{-- Current Image --}}
                        <div class="col-md-6">
                            <div class="form-group">

                                <label>
                                    Current Image
                                </label>

                                <div>
                                    @if ($subCategory->image)
                                        <img src="{{ asset('storage/' . $subCategory->image) }}"
                                            alt="{{ $subCategory->name }}" width="100" height="100"
                                            style="object-fit: cover;" class="rounded border">
                                    @else
                                        <p class="text-muted">
                                            No image uploaded.
                                        </p>
                                    @endif
                                </div>

                            </div>
                        </div>


                        {{-- New Image --}}
                        <div class="col-md-6">
                            <div class="form-group">

                                <label for="image">
                                    Change Image
                                </label>

                                <input type="file" name="image" id="image"
                                    class="form-control @error('image') is-invalid @enderror"
                                    accept=".jpg,.jpeg,.png,.webp">

                                <small class="text-muted">
                                    JPG, JPEG, PNG or WEBP. Maximum 2MB.
                                </small>

                                @error('image')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>
                        </div>

                    </div>


                    <div class="mt-3">

                        <button type="submit" class="btn btn-primary">
                            Update Sub-Category
                        </button>

                        <a href="{{ route('sub-categories.index') }}" class="btn btn-secondary">
                            Cancel
                        </a>

                    </div>

                </form>

            </div>
        </div>

    </div>
@endsection
