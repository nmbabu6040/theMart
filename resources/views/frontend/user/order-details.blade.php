@extends('frontend.layouts.app')

@section('content')
    <div class="order-details">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="order-details-wrap">
                        <div class="order-details-top">
                            <table class="order-details-table">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Order Items</th>
                                        <th>Total Amount</th>
                                        <th>Status</th>

                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $order->created_at->format('d M, Y') }}</td>
                                        <td>
                                            <ul>
                                                @if (isset($order->orderDetails) && $order->orderDetails->count() > 0)
                                                    @foreach ($order->orderDetails as $item)
                                                        <li>
                                                            {{ $item->order_Items->product_name ?? 'Product Item' }}
                                                        </li>
                                                    @endforeach
                                                @else
                                                    <li>No item details available.</li>
                                                @endif
                                            </ul>
                                        </td>
                                        <td>${{ number_format($order->total_amount ?? $order->grand_total, 2) }}</td>
                                        <td>
                                            <span class="badge bg-info text-capitalize">
                                                {{ $order->status ?? 'Pending' }}
                                            </span>
                                        </td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
