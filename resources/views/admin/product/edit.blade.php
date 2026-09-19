@extends('admin.layouts.master')

@section('content')

    <div class="page-content">

        {{-- ========================================================= --}}
        {{-- Header --}}
        {{-- ========================================================= --}}

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h3 class="mb-0">
                Edit Product
            </h3>

            <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">
                Back
            </a>

        </div>


        {{-- ========================================================= --}}
        {{-- Success Message --}}
        {{-- ========================================================= --}}

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif


        {{-- ========================================================= --}}
        {{-- Error Message --}}
        {{-- ========================================================= --}}

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif


        {{-- ========================================================= --}}
        {{-- Validation Errors --}}
        {{-- ========================================================= --}}

        @if ($errors->any())
            <div class="alert alert-danger">

                <strong>
                    Please fix the following errors:
                </strong>

                <ul class="mb-0 mt-2">

                    @foreach ($errors->all() as $error)
                        <li>
                            {{ $error }}
                        </li>
                    @endforeach

                </ul>

            </div>
        @endif


        {{-- ========================================================= --}}
        {{-- Main Product Update Form --}}
        {{-- ========================================================= --}}

        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">

            @csrf
            @method('PUT')


            {{-- ===================================================== --}}
            {{-- Basic Information --}}
            {{-- ===================================================== --}}

            <div class="card mb-4">

                <div class="card-header">
                    <h5 class="mb-0">
                        Basic Information
                    </h5>
                </div>

                <div class="card-body">

                    <div class="row g-3">

                        {{-- Product Name --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Product Name
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="name" value="{{ old('name', $product->name) }}"
                                class="form-control" placeholder="Product name" required>

                        </div>


                        {{-- SKU --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                SKU
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="sku" value="{{ old('sku', $product->sku) }}"
                                class="form-control" placeholder="SKU" required>

                        </div>


                        {{-- Category --}}
                        <div class="col-md-4">

                            <label class="form-label">
                                Category
                                <span class="text-danger">*</span>
                            </label>

                            <select name="category_id" class="form-select" required>

                                <option value="">
                                    Select Category
                                </option>

                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach

                            </select>

                        </div>


                        {{-- Sub Category --}}
                        <div class="col-md-4">

                            <label class="form-label">
                                Sub Category
                            </label>

                            <select name="sub_category_id" class="form-select">

                                <option value="">
                                    Select Sub Category
                                </option>

                                @foreach ($subCategories as $subCategory)
                                    <option value="{{ $subCategory->id }}" @selected(old('sub_category_id', $product->sub_category_id) == $subCategory->id)>
                                        {{ $subCategory->name }}
                                    </option>
                                @endforeach

                            </select>

                        </div>


                        {{-- Brand --}}
                        <div class="col-md-4">

                            <label class="form-label">
                                Brand
                            </label>

                            <select name="brand_id" class="form-select">

                                <option value="">
                                    Select Brand
                                </option>

                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}" @selected(old('brand_id', $product->brand_id) == $brand->id)>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach

                            </select>

                        </div>


                        {{-- Short Description --}}
                        <div class="col-md-12">

                            <label class="form-label">
                                Short Description
                            </label>

                            <textarea name="short_description" rows="3" class="form-control" placeholder="Short description">{{ old('short_description', $product->short_description) }}</textarea>

                        </div>


                        {{-- Description --}}
                        <div class="col-md-12">

                            <label class="form-label">
                                Description
                            </label>

                            <textarea name="description" rows="6" class="form-control" placeholder="Product description">{{ old('description', $product->description) }}</textarea>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- Pricing & Inventory --}}
            {{-- ===================================================== --}}

            <div class="card mb-4">

                <div class="card-header">
                    <h5 class="mb-0">
                        Pricing & Inventory
                    </h5>
                </div>

                <div class="card-body">

                    <div class="row g-3">

                        <div class="col-md-3">

                            <label class="form-label">
                                Buying Price
                            </label>

                            <input type="number" step="0.01" min="0" name="buying_price"
                                value="{{ old('buying_price', $product->buying_price) }}" class="form-control">

                        </div>


                        <div class="col-md-3">

                            <label class="form-label">
                                Sale Price
                                <span class="text-danger">*</span>
                            </label>

                            <input type="number" step="0.01" min="0" name="sale_price"
                                value="{{ old('sale_price', $product->sale_price) }}" class="form-control" required>

                        </div>


                        <div class="col-md-3">

                            <label class="form-label">
                                Discount (%)
                            </label>

                            <input type="number" step="0.01" min="0" name="discount"
                                value="{{ old('discount', $product->discount) }}" class="form-control">

                        </div>


                        <div class="col-md-3">

                            <label class="form-label">
                                Discount Price
                            </label>

                            <input type="number" step="0.01" min="0" name="discount_price"
                                value="{{ old('discount_price', $product->discount_price) }}" class="form-control">

                        </div>


                        <div class="col-md-3">

                            <label class="form-label">
                                Stock
                            </label>

                            <input type="number" min="0" name="stock"
                                value="{{ old('stock', $product->stock) }}" class="form-control">

                        </div>

                    </div>

                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- Sizes --}}
            {{-- ===================================================== --}}

            <div class="card mb-4">

                <div class="card-header">
                    <h5 class="mb-0">
                        Sizes
                    </h5>
                </div>

                <div class="card-body">

                    <div class="row">

                        @forelse ($sizes as $size)
                            <div class="col-md-2 mb-2">

                                <div class="form-check">

                                    <input class="form-check-input" type="checkbox" name="sizes[]"
                                        value="{{ $size->id }}" id="size_{{ $size->id }}"
                                        @checked(in_array($size->id, old('sizes', $product->sizes->pluck('id')->toArray())))>

                                    <label class="form-check-label" for="size_{{ $size->id }}">
                                        {{ $size->name }}
                                    </label>

                                </div>

                            </div>

                        @empty

                            <div class="col-12">
                                <span class="text-muted">
                                    No size found.
                                </span>
                            </div>
                        @endforelse

                    </div>

                </div>

            </div>



            {{-- ========================================================= --}}
            {{-- Colors --}}
            {{-- ========================================================= --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Colors</h5>
                </div>

                <div class="card-body">

                    @php
                        $selectedColors = old('colors', $product->colors->pluck('id')->toArray());
                    @endphp

                    @if ($colors->isNotEmpty())
                        <div class="row g-3">

                            @foreach ($colors as $color)
                                <div class="col-6 col-md-4 col-lg-3 col-xl-2">

                                    <div class="color-option">

                                        <input type="checkbox" name="colors[]" value="{{ $color->id }}"
                                            id="edit_color_{{ $color->id }}" class="color-checkbox"
                                            @checked(in_array($color->id, $selectedColors))>

                                        <label for="edit_color_{{ $color->id }}" class="color-label">

                                            <span class="color-swatch"
                                                style="
                                        background-color: {{ trim($color->code) }};
                                    "
                                                title="{{ $color->name }}"></span>

                                            <span class="color-name">
                                                {{ $color->name }}
                                            </span>

                                        </label>

                                    </div>

                                </div>
                            @endforeach

                        </div>
                    @else
                        <div class="alert alert-light border mb-0">
                            No active colors found.
                        </div>
                    @endif

                </div>
            </div>



            {{-- ===================================================== --}}
            {{-- Tags --}}
            {{-- ===================================================== --}}

            <div class="card mb-4">

                <div class="card-header">
                    <h5 class="mb-0">
                        Tags
                    </h5>
                </div>

                <div class="card-body">

                    <div class="row">

                        @forelse ($tags as $tag)
                            <div class="col-md-2 mb-2">

                                <div class="form-check">

                                    <input class="form-check-input" type="checkbox" name="tags[]"
                                        value="{{ $tag->id }}" id="tag_{{ $tag->id }}"
                                        @checked(in_array($tag->id, old('tags', $product->tags->pluck('id')->toArray())))>

                                    <label class="form-check-label" for="tag_{{ $tag->id }}">
                                        {{ $tag->name }}
                                    </label>

                                </div>

                            </div>

                        @empty

                            <div class="col-12">
                                <span class="text-muted">
                                    No tag found.
                                </span>
                            </div>
                        @endforelse

                    </div>

                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- Product Images --}}
            {{-- ===================================================== --}}

            <div class="card mb-4">

                <div class="card-header">

                    <h5 class="mb-0">
                        Product Images
                    </h5>

                </div>

                <div class="card-body">


                    {{-- ================================================= --}}
                    {{-- Thumbnail --}}
                    {{-- ================================================= --}}

                    <div class="mb-4">

                        <label for="thumbnail" class="form-label fw-semibold">
                            Product Thumbnail
                        </label>


                        @if ($product->thumbnail)
                            <div class="mb-3">

                                <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}"
                                    class="img-thumbnail"
                                    style="
                                        width: 140px;
                                        height: 140px;
                                        object-fit: cover;
                                    ">

                            </div>
                        @else
                            <div class="text-muted mb-3">
                                No thumbnail uploaded.
                            </div>
                        @endif


                        <input type="file" name="thumbnail" id="thumbnail" class="form-control"
                            accept="image/jpeg,image/png,image/webp">

                        <small class="text-muted">
                            JPG, PNG or WebP. Maximum 2MB.
                        </small>

                    </div>


                    <hr>


                    {{-- ================================================= --}}
                    {{-- Existing Gallery --}}
                    {{-- ================================================= --}}

                    <div class="mb-4">

                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <h6 class="fw-semibold mb-0">
                                Existing Gallery
                            </h6>

                            @if ($product->images->isNotEmpty())
                                <span class="badge bg-secondary">
                                    {{ $product->images->count() }}
                                    {{ $product->images->count() === 1 ? 'Image' : 'Images' }}
                                </span>
                            @endif

                        </div>


                        @if ($product->images->isNotEmpty())
                            <div class="row g-3">

                                @foreach ($product->images as $image)
                                    <div class="col-6 col-md-4 col-lg-3 col-xl-2">

                                        <div class="card h-100 shadow-sm">


                                            {{-- Image --}}
                                            <div class="position-relative">

                                                <img src="{{ asset('storage/' . $image->image) }}"
                                                    alt="{{ $product->name }}" class="card-img-top"
                                                    style="
                                                        width: 100%;
                                                        height: 160px;
                                                        object-fit: cover;
                                                    ">


                                                {{-- Primary Badge --}}
                                                @if ($image->is_primary)
                                                    <span class="position-absolute top-0 start-0 badge bg-success m-2">
                                                        Primary
                                                    </span>
                                                @endif


                                                {{-- Image Order --}}
                                                <span class="position-absolute bottom-0 end-0 badge bg-dark m-2">
                                                    #{{ $image->sort_order }}
                                                </span>

                                            </div>


                                            {{-- Actions --}}
                                            <div class="card-body p-2">


                                                {{-- Make Primary --}}
                                                @if (!$image->is_primary)
                                                    <form
                                                        action="{{ route('products.images.primary', [
                                                            'product' => $product->id,
                                                            'image' => $image->id,
                                                        ]) }}"
                                                        method="POST" class="mb-2">

                                                        @csrf
                                                        @method('PATCH')

                                                        <button type="submit"
                                                            class="btn btn-outline-success btn-sm w-100">
                                                            <i class="bi bi-star me-1"></i>
                                                            Make Primary
                                                        </button>

                                                    </form>
                                                @else
                                                    <button type="button" class="btn btn-success btn-sm w-100 mb-2"
                                                        disabled>
                                                        <i class="bi bi-check-circle me-1"></i>
                                                        Primary Image
                                                    </button>
                                                @endif


                                                {{-- Delete --}}
                                                <form
                                                    action="{{ route('products.images.delete', [
                                                        'product' => $product->id,
                                                        'image' => $image->id,
                                                    ]) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this gallery image? This action cannot be undone.');">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                                        <i class="bi bi-trash me-1"></i>
                                                        Delete
                                                    </button>

                                                </form>

                                            </div>

                                        </div>

                                    </div>
                                @endforeach

                            </div>
                        @else
                            <div class="alert alert-light border mb-0">
                                No gallery images found.
                            </div>
                        @endif

                    </div>


                    <hr>


                    {{-- ================================================= --}}
                    {{-- Add Gallery Images --}}
                    {{-- ================================================= --}}

                    <div>

                        <h6 class="fw-semibold mb-3">
                            Add New Gallery Images
                        </h6>

                        <input type="file" name="images[]" id="images" class="form-control"
                            accept="image/jpeg,image/png,image/webp" multiple>

                        <small class="text-muted d-block mt-2">
                            Select one or multiple images.
                            Maximum 2MB per image.
                        </small>

                    </div>

                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- SEO --}}
            {{-- ===================================================== --}}

            <div class="card mb-4">

                <div class="card-header">

                    <h5 class="mb-0">
                        SEO
                    </h5>

                </div>

                <div class="card-body">

                    <div class="row g-3">

                        <div class="col-md-12">

                            <label class="form-label">
                                Meta Title
                            </label>

                            <input type="text" name="meta_title"
                                value="{{ old('meta_title', $product->meta_title) }}" class="form-control">

                        </div>


                        <div class="col-md-12">

                            <label class="form-label">
                                Meta Description
                            </label>

                            <textarea name="meta_description" rows="4" class="form-control">{{ old('meta_description', $product->meta_description) }}</textarea>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- Product Status --}}
            {{-- ===================================================== --}}

            <div class="card mb-4">

                <div class="card-header">

                    <h5 class="mb-0">
                        Product Status & Visibility
                    </h5>

                </div>

                <div class="card-body">

                    <div class="row g-3">


                        {{-- Featured --}}
                        <div class="col-md-3">

                            <div class="form-check form-switch">

                                <input type="checkbox" name="featured" value="1" class="form-check-input"
                                    id="featured" @checked(old('featured', $product->featured))>

                                <label class="form-check-label" for="featured">
                                    Featured Product
                                </label>

                            </div>

                        </div>


                        {{-- Interest --}}
                        <div class="col-md-3">

                            <div class="form-check form-switch">

                                <input type="checkbox" name="is_interest" value="1" class="form-check-input"
                                    id="is_interest" @checked(old('is_interest', $product->is_interest))>

                                <label class="form-check-label" for="is_interest">
                                    Product of Interest
                                </label>

                            </div>

                        </div>


                        {{-- Trending --}}
                        <div class="col-md-3">

                            <div class="form-check form-switch">

                                <input type="checkbox" name="is_trending" value="1" class="form-check-input"
                                    id="is_trending" @checked(old('is_trending', $product->is_trending))>

                                <label class="form-check-label" for="is_trending">
                                    Trending Product
                                </label>

                            </div>

                        </div>


                        {{-- Status --}}
                        <div class="col-md-3">

                            <div class="form-check form-switch">

                                <input type="checkbox" name="status" value="1" class="form-check-input"
                                    id="status" @checked(old('status', $product->status))>

                                <label class="form-check-label" for="status">
                                    Active
                                </label>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- Submit --}}
            {{-- ===================================================== --}}

            <div class="mb-5">

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i>
                    Update Product
                </button>

                <a href="{{ route('products.index') }}" class="btn btn-secondary">
                    Cancel
                </a>

            </div>

        </form>

    </div>

@endsection

@push('style')
    <style>

        /* =========================================================
       Product Color Selection
       ========================================================= */

        .color-option {
            position: relative;
        }

        .color-checkbox {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .color-label {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            background: #fff;
            cursor: pointer;
            transition: all 0.2s ease;
            min-height: 48px;
        }

        .color-label:hover {
            border-color: #adb5bd;
        }

        .color-checkbox:checked+.color-label {
            border-color: #212529;
            box-shadow: 0 0 0 2px rgba(33, 37, 41, 0.08);
        }

        .color-swatch {
            width: 28px;
            height: 28px;
            min-width: 28px;
            border-radius: 50%;
            border: 1px solid #ced4da;
            display: inline-block;
            box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.05);
        }

        .color-name {
            font-size: 14px;
            font-weight: 500;
            color: #212529;
            line-height: 1.2;
        }


    </style>
@endpush
