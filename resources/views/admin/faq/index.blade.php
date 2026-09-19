@extends('admin.layouts.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <!-- Add FAQ Form -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Add New FAQ</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('faq.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label>Question</label>
                                    <input type="text" name="question" class="form-control" required
                                        placeholder="Enter Question">
                                </div>
                                <div class="mb-3">
                                    <label>Answer</label>
                                    <textarea name="answer" class="form-control" rows="4" required placeholder="Enter Answer"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Save FAQ</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- FAQ List -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>All FAQs</h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Question</th>
                                        <th>Answer</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($faqs as $key => $faq)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ Str::limit($faq->question, 20) }}</td>
                                            <td>{{ Str::limit($faq->answer, 30) }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <!-- Edit Button -->
                                                    <a href="{{ route('faq.edit', $faq->id) }}"
                                                        class="btn btn-warning btn-sm">Edit</a>

                                                    <!-- Delete Button -->
                                                    <form action="{{ route('faq.destroy', $faq->id) }}" method="POST"
                                                        onsubmit="return confirm('Delete this FAQ?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger btn-sm">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No FAQs found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
