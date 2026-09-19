@extends('admin.layouts.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <!-- Edit FAQ Form -->
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit FAQ</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('faq.update', $faq->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label>Question</label>
                                    <input type="text" name="question" class="form-control"
                                        value="{{ old('question', $faq->question) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label>Answer</label>
                                    <textarea name="answer" class="form-control" rows="4" required>{{ old('answer', $faq->answer) }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="1" {{ $faq->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $faq->status == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success">Update FAQ</button>
                                <a href="{{ route('faq.index') }}" class="btn btn-secondary">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- FAQ List -->
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header">
                            <h4>All FAQs</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Question</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($faqs as $key => $item)
                                        <tr class="{{ $item->id == $faq->id ? 'table-active' : '' }}">
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ Str::limit($item->question, 40) }}</td>
                                            <td>
                                                <span class="badge {{ $item->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $item->status == 1 ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('faq.edit', $item->id) }}"
                                                    class="btn btn-warning btn-sm">Edit</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
