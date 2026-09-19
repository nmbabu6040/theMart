@extends('admin.layouts.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h4>Submitted User Questions</h4>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Status</th>
                                <th>Submitted At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($questions as $key => $q)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $q->name }}</td>
                                    <td>{{ $q->email }}</td>
                                    <td>{{ $q->subject ?? 'N/A' }}</td>
                                    <td>
                                        @if ($q->is_read)
                                            <span class="badge bg-secondary">Read</span>
                                        @else
                                            <span class="badge bg-success">New</span>
                                        @endif
                                    </td>
                                    <td>{{ $q->created_at->format('d M Y, h:i A') }}</td>
                                    <td>
                                        <a href="{{ route('questions.show', $q->id) }}" class="btn btn-info btn-sm">View</a>
                                        <form action="{{ route('questions.destroy', $q->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Delete this message?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No questions submitted yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $questions->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
