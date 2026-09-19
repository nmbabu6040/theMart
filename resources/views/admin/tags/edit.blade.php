@extends('admin.layouts.master')

@section('content')
    <div class="page-content">

        <div class="category-header d-flex justify-content-between align-items-center mb-4">

            <h3>Edit Tag</h3>

            <div class="d-flex gap-2">
                <a href="{{ route('tags.index') }}" class="btn btn-primary btn-sm">
                    All
                </a>

                <a href="{{ route('tags.trash') }}" class="btn btn-danger btn-sm">
                    Trash
                </a>
            </div>

        </div>

        <div class="card">
            <div class="card-body">

                <form action="{{ route('tags.update', $tag) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="row">

                        {{-- Name --}}
                        <div class="col-md-6">
                            <div class="form-group">

                                <label for="name">
                                    Tag Name
                                </label>

                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $tag->name) }}"
                                    placeholder="Tag Name">

                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>
                        </div>

                        {{-- Slug --}}
                        <div class="col-md-6">
                            <div class="form-group">

                                <label for="slug">
                                    Slug
                                </label>

                                <input type="text" class="form-control" id="slug" value="{{ $tag->slug }}"
                                    readonly>

                            </div>
                        </div>

                        {{-- Sort Order --}}
                        <div class="col-md-6">
                            <div class="form-group">

                                <label for="sort_order">
                                    Sort Order
                                </label>

                                <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                                    id="sort_order" name="sort_order" value="{{ old('sort_order', $tag->sort_order) }}"
                                    min="0" placeholder="0">

                                @error('sort_order')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="col-md-6">
                            <div class="form-group">

                                <label for="status">
                                    Status
                                </label>

                                <select name="status" id="status"
                                    class="form-control @error('status') is-invalid @enderror">

                                    <option value="1"
                                        {{ old('status', $tag->status ? '1' : '0') == '1' ? 'selected' : '' }}>
                                        Active
                                    </option>

                                    <option value="0"
                                        {{ old('status', $tag->status ? '1' : '0') == '0' ? 'selected' : '' }}>
                                        Inactive
                                    </option>

                                </select>

                                @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>
                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary">
                        Update Tag
                    </button>

                    <a href="{{ route('tags.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>

                </form>

            </div>
        </div>

    </div>
@endsection
