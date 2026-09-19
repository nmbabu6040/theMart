@extends('admin.layouts.master')

@section('content')
    <div class="page-content">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h4 class="mb-1">Edit Color</h4>
                <p class="text-muted mb-0">
                    Update product color information.
                </p>
            </div>

            <div class="d-flex gap-2">

                <a href="{{ route('colors.index') }}" class="btn btn-outline-primary btn-sm">
                    All Colors
                </a>

                <a href="{{ route('colors.trash') }}" class="btn btn-outline-danger btn-sm">
                    Trash
                </a>

            </div>

        </div>


        <div class="card">
            <div class="card-body">

                <form action="{{ route('colors.update', $color->id) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="row">

                        {{-- Color Name --}}
                        <div class="col-md-6">
                            <div class="form-group">

                                <label for="name">
                                    Color Name
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="text" name="name" id="name" value="{{ old('name', $color->name) }}"
                                    class="form-control @error('name') is-invalid @enderror">

                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>
                        </div>


                        {{-- Color Code --}}
                        <div class="col-md-6">
                            <div class="form-group">

                                <label for="code">
                                    Color Code
                                    <span class="text-danger">*</span>
                                </label>

                                <div class="input-group">

                                    <input type="color" id="color_picker" value="{{ old('code', $color->code) }}"
                                        class="form-control">

                                    <input type="text" name="code" id="code"
                                        value="{{ old('code', $color->code) }}"
                                        class="form-control @error('code') is-invalid @enderror">

                                </div>

                                @error('code')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>
                        </div>


                        {{-- Sort Order --}}
                        <div class="col-md-6">
                            <div class="form-group">

                                <label for="sort_order">
                                    Sort Order
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="number" name="sort_order" id="sort_order"
                                    value="{{ old('sort_order', $color->sort_order) }}" min="0"
                                    class="form-control @error('sort_order') is-invalid @enderror">

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
                                    <span class="text-danger">*</span>
                                </label>

                                <select name="status" id="status"
                                    class="form-control @error('status') is-invalid @enderror">

                                    <option value="1"
                                        {{ old('status', $color->status ? '1' : '0') == '1' ? 'selected' : '' }}>
                                        Active
                                    </option>

                                    <option value="0"
                                        {{ old('status', $color->status ? '1' : '0') == '0' ? 'selected' : '' }}>
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
                            Update Color
                        </button>

                        <a href="{{ route('colors.index') }}" class="btn btn-secondary">
                            Cancel
                        </a>

                    </div>

                </form>

            </div>
        </div>

    </div>
@endsection


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const colorPicker = document.getElementById('color_picker');
            const colorCode = document.getElementById('code');

            colorPicker.addEventListener('input', function() {
                colorCode.value = this.value.toUpperCase();
            });

            colorCode.addEventListener('input', function() {

                const value = this.value.trim();

                if (/^#([A-Fa-f0-9]{6})$/.test(value)) {
                    colorPicker.value = value;
                }

            });

        });
    </script>
@endpush
