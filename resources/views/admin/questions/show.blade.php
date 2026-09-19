@extends('admin.layouts.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Question Details</h4>
                    <a href="{{ route('questions.index') }}" class="btn btn-secondary btn-sm">Back to List</a>
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $question->name }}</p>
                    <p><strong>Email:</strong> {{ $question->email }}</p>
                    <p><strong>Subject:</strong> {{ $question->subject ?? 'N/A' }}</p>
                    <p><strong>Date:</strong> {{ $question->created_at->format('d M Y, h:i A') }}</p>
                    <hr>
                    <h5>Message / Question:</h5>
                    <p class="p-3 bg-light rounded">{{ $question->note }}</p>

                    <form action="{{ route('questions.destroy', $question->id) }}" method="POST" class="mt-3"
                        onsubmit="return confirm('Delete this message?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">Delete Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
