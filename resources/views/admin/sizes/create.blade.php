@extends('admin.layouts.master')

@section('content')
    <div class="page-content">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h3 class="mb-1">Add Size</h3>
                {{-- <p class="text-muted mb-0">
                    Create a new product size.
                </p> --}}
            </div>


            <div class="gap-2">

                <a href="{{ route('sizes.index') }}" class="btn btn-primary btn-sm">
                    All Sizes
                </a>


                <a href="{{ route('sizes.trash') }}" class="btn btn-danger btn-sm">
                    Trash
                </a>

            </div>

        </div>


        <div class="card">

            <div class="card-body">

                <form action="{{ route('sizes.store') }}" method="POST">

                    @csrf


                    <div class="row">

                        {{-- Size Name --}}
                        <div class="col-md-6">

                            <div class="mb-3">

                                <label for="name" class="form-label">

                                    Size Name
                                    <span class="text-danger">*</span>

                                </label>


                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Example: S, M, L, XL">


                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>


                        {{-- Sort Order --}}
                        <div class="col-md-6">

                            <div class="mb-3">

                                <label for="sort_order" class="form-label">

                                    Sort Order
                                    <span class="text-danger">*</span>

                                </label>


                                <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}"
                                    min="0" class="form-control @error('sort_order') is-invalid @enderror"
                                    placeholder="Example: 1">


                                @error('sort_order')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>


                        {{-- Status --}}
                        <div class="col-md-6">

                            <div class="mb-3">

                                <label for="status" class="form-label">

                                    Status
                                    <span class="text-danger">*</span>

                                </label>


                                <select name="status" id="status"
                                    class="form-select @error('status') is-invalid @enderror">

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

                            Save Size

                        </button>


                        <a href="{{ route('sizes.index') }}" class="btn btn-secondary">

                            Cancel

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>
@endsection
