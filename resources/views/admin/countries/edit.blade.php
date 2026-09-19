@extends('admin.layouts.master')

@section('content')

    <div class="page-content">

        <div class="category-header d-flex justify-content-between align-items-center mb-4">

            <h3>Edit Country</h3>

            <div class="gap-2">

                <a href="{{ route('countries.index') }}" class="btn btn-primary btn-sm">
                    All Countries
                </a>

            </div>

        </div>


        <div class="card">

            <div class="card-body">

                {{-- Validation Errors --}}
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


                <form action="{{ route('countries.update', $country->id) }}" method="POST">

                    @csrf
                    @method('PUT')


                    <div class="row">

                        {{-- Country Name --}}
                        <div class="col-md-6">

                            <div class="form-group mb-3">

                                <label for="name">
                                    Country Name
                                </label>

                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $country->name) }}"
                                    placeholder="Enter country name" required>

                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>


                        {{-- Country Code --}}
                        <div class="col-md-6">

                            <div class="form-group mb-3">

                                <label for="code">
                                    Country Code
                                </label>

                                <input type="text" class="form-control @error('code') is-invalid @enderror"
                                    id="code" name="code" value="{{ old('code', $country->code) }}"
                                    placeholder="Example: BD" maxlength="5">

                                @error('code')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <small class="text-muted">
                                    Optional. Example: BD, US, IN
                                </small>

                            </div>

                        </div>

                    </div>


                    <div class="mt-3">

                        <button type="submit" class="btn btn-primary">
                            Update Country
                        </button>

                        <a href="{{ route('countries.index') }}" class="btn btn-secondary">
                            Cancel
                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection
