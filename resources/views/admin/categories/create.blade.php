@extends('admin.layouts.master')

@section('content')

    <div class="page-content">

        <div class="category-header d-flex justify-content-between align-items-center mb-4">

            <h3>Add Category</h3>

            <div class="gap-2">
                <a href="{{ route('categories.index') }}" class="btn btn-primary btn-sm">
                    All
                </a>

                <a href="{{ route('categories.trash') }}" class="btn btn-danger btn-sm">
                    Trash
                </a>
            </div>

        </div>


        <div class="card">

            <div class="card-body">

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger">

                        <strong>Please fix the following errors:</strong>

                        <ul class="mb-0 mt-2">

                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach

                        </ul>

                    </div>
                @endif


                <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">

                    @csrf


                    <div class="row">

                        {{-- Category Name --}}
                        <div class="col-md-6">

                            <div class="form-group mb-3">

                                <label for="name">
                                    Category Name
                                </label>

                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}"
                                    placeholder="Enter category name" required>

                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>


                        {{-- Image --}}
                        <div class="col-md-6">

                            <div class="form-group mb-3">

                                <label for="image">
                                    Category Image
                                </label>

                                <input type="file" class="form-control @error('image') is-invalid @enderror"
                                    id="image" name="image" accept=".jpg,.jpeg,.png,.webp">

                                @error('image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <small class="text-muted">
                                    JPG, JPEG, PNG or WEBP. Maximum 2MB.
                                </small>

                            </div>

                        </div>


                        {{-- Status --}}
                        <div class="col-md-6">

                            <div class="form-group mb-3">

                                <label for="status">
                                    Status
                                </label>

                                <select name="status" id="status"
                                    class="form-control @error('status') is-invalid @enderror">

                                    <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>
                                        Active
                                    </option>

                                    <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>
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


                    <div class="mt-3">

                        <button type="submit" class="btn btn-primary">
                            Save Category
                        </button>

                        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                            Cancel
                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection
