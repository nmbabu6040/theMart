@extends('admin.layouts.master') {{-- Apnar admin layout format onusare change korben --}}

@section('content')
    <div class="container">
        <div class="page-content">
            <h2>All Orders</h2>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Customer Name</th>
                        <th>Total</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>#{{ $order->order_number }}</td>
                            <td>{{ $order->created_at->format('d M, Y') }}</td>
                            <td>{{ $order->user->name ?? 'Guest' }}</td>
                            <td>${{ $order->total_amount }}</td>
                            <td>
                                <span class="badge bg-info text-capitalize">
                                    {{ $order->payment_status }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-info text-capitalize">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-primary">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $orders->links() }}
        </div>
    </div>
@endsection
