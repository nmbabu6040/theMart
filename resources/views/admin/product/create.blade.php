@extends('admin.layouts.master')

@section('content')

    <div class="page-content">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Add Product</h3>
            <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">
                Back
            </a>
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

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- ========================================================= --}}
            {{-- Basic Information --}}
            {{-- ========================================================= --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Basic Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        {{-- Name --}}
                        <div class="col-md-6">
                            <label class="form-label">
                                Product Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                                placeholder="Product name" required>
                        </div>

                        {{-- SKU --}}
                        <div class="col-md-6">
                            <label class="form-label">
                                SKU <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="sku" value="{{ old('sku') }}" class="form-control"
                                placeholder="SKU" required>
                        </div>

                        {{-- Category --}}
                        <div class="col-md-4">
                            <label class="form-label">
                                Category <span class="text-danger">*</span>
                            </label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Sub Category --}}
                        <div class="col-md-4">
                            <label class="form-label">Sub Category</label>
                            <select name="sub_category_id" class="form-select">
                                <option value="">Select Sub Category</option>
                                @foreach ($subCategories as $subCategory)
                                    <option value="{{ $subCategory->id }}" @selected(old('sub_category_id') == $subCategory->id)>
                                        {{ $subCategory->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Brand --}}
                        <div class="col-md-4">
                            <label class="form-label">Brand</label>
                            <select name="brand_id" class="form-select">
                                <option value="">Select Brand</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}" @selected(old('brand_id') == $brand->id)>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Short Description --}}
                        <div class="col-md-12">
                            <label class="form-label">Short Description</label>
                            <textarea name="short_description" rows="3" class="form-control" placeholder="Short description">{{ old('short_description') }}</textarea>
                        </div>

                        {{-- Description --}}
                        <div class="col-md-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="6" class="form-control" placeholder="Product description">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ========================================================= --}}
            {{-- Pricing & Inventory --}}
            {{-- ========================================================= --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Pricing & Inventory</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        {{-- Buying Price --}}
                        <div class="col-md-3">
                            <label class="form-label">Buying Price</label>
                            <input type="number" step="0.01" name="buying_price" value="{{ old('buying_price', 0) }}"
                                class="form-control">
                        </div>

                        {{-- Sale Price --}}
                        <div class="col-md-3">
                            <label class="form-label">
                                Sale Price <span class="text-danger">*</span>
                            </label>
                            <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price') }}"
                                class="form-control" required>
                        </div>

                        {{-- Discount --}}
                        <div class="col-md-3">
                            <label class="form-label">Discount (%)</label>
                            <input type="number" step="0.01" name="discount" value="{{ old('discount', 0) }}"
                                class="form-control">
                        </div>

                        {{-- Discount Price --}}
                        <div class="col-md-3">
                            <label class="form-label">Discount Price</label>
                            <input type="number" step="0.01" name="discount_price"
                                value="{{ old('discount_price', 0) }}" class="form-control">
                        </div>

                        {{-- Stock --}}
                        <div class="col-md-3">
                            <label class="form-label">Stock</label>
                            <input type="number" name="stock" value="{{ old('stock', 0) }}" class="form-control"
                                min="0">
                        </div>
                    </div>
                </div>
            </div>

            {{-- ========================================================= --}}
            {{-- Sizes --}}
            {{-- ========================================================= --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Sizes</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse ($sizes as $size)
                            <div class="col-md-2 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sizes[]"
                                        value="{{ $size->id }}" id="size_{{ $size->id }}"
                                        @checked(in_array($size->id, old('sizes', [])))>
                                    <label class="form-check-label" for="size_{{ $size->id }}">
                                        {{ $size->name }}
                                    </label>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <span class="text-muted">No size found.</span>
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

                    @if ($colors->isNotEmpty())
                        <div class="row g-3">

                            @foreach ($colors as $color)
                                <div class="col-6 col-md-4 col-lg-3 col-xl-2">

                                    <div class="color-option">

                                        <input type="checkbox" name="colors[]" value="{{ $color->id }}"
                                            id="color_{{ $color->id }}" class="color-checkbox"
                                            @checked(in_array($color->id, old('colors', [])))>

                                        <label for="color_{{ $color->id }}" class="color-label">

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



            {{-- ========================================================= --}}
            {{-- Tags --}}
            {{-- ========================================================= --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Tags</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse ($tags as $tag)
                            <div class="col-md-2 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="tags[]"
                                        value="{{ $tag->id }}" id="tag_{{ $tag->id }}"
                                        @checked(in_array($tag->id, old('tags', [])))>
                                    <label class="form-check-label" for="tag_{{ $tag->id }}">
                                        {{ $tag->name }}
                                    </label>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <span class="text-muted">No tag found.</span>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- ========================================================= --}}
            {{-- Images --}}
            {{-- ========================================================= --}}
            <div class="card mb-4">


                <div class="card-header">
                    <label for="thumbnail">Product Thumbnail</label>
                    <input type="file" name="thumbnail" id="thumbnail" class="form-control" accept="image/*">
                </div>
                <div class="card-body">
                    <label class="form-label">Product Gallery</label>
                    <input type="file" name="images[]" class="form-control" accept="image/jpeg,image/png,image/webp"
                        multiple>
                    <small class="text-muted">
                        You can select multiple images. Maximum 2MB per image.
                    </small>
                </div>
            </div>

            {{-- ========================================================= --}}
            {{-- SEO --}}
            {{-- ========================================================= --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">SEO</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Meta Title</label>
                            <input type="text" name="meta_title" value="{{ old('meta_title') }}"
                                class="form-control">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Meta Description</label>
                            <textarea name="meta_description" rows="4" class="form-control">{{ old('meta_description') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ========================================================= --}}
            {{-- Status & Visibility Flags --}}
            {{-- ========================================================= --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Product Status & Visibility</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        {{-- Featured --}}
                        <div class="col-md-3">
                            <div class="form-check form-switch">
                                <input type="checkbox" name="featured" value="1" class="form-check-input"
                                    id="featured" @checked(old('featured'))>
                                <label class="form-check-label" for="featured">Featured Product</label>
                            </div>
                        </div>

                        {{-- Product of Interest --}}
                        <div class="col-md-3">
                            <div class="form-check form-switch">
                                <input type="checkbox" name="is_interest" value="1" class="form-check-input"
                                    id="is_interest" @checked(old('is_interest'))>
                                <label class="form-check-label" for="is_interest">Product of Interest</label>
                            </div>
                        </div>

                        {{-- Trending --}}
                        <div class="col-md-3">
                            <div class="form-check form-switch">
                                <input type="checkbox" name="is_trending" value="1" class="form-check-input"
                                    id="is_trending" @checked(old('is_trending'))>
                                <label class="form-check-label" for="is_trending">Trending Product</label>
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="col-md-3">
                            <div class="form-check form-switch">
                                <input type="checkbox" name="status" value="1" class="form-check-input"
                                    id="status" @checked(old('status', true))>
                                <label class="form-check-label" for="status">Active</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Submit --}}
            <div class="mb-5">
                <button type="submit" class="btn btn-primary">Save Product</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
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
