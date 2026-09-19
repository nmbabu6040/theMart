@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="page-content">
            <h2>Order Details #{{ $order->order_number ?? $order->id }}</h2>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="row">
                {{-- Order Summary & Status Update --}}
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Order Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Customer Name:</strong> {{ $order->user->name ?? 'Guest' }}</p>
                                    <p><strong>Email:</strong> {{ $order->user->email ?? ($order->email ?? 'N/A') }}</p>
                                    <p><strong>Phone:</strong> {{ $order->billing_phone ?? 'N/A' }}</p>
                                    <p><strong>Address:</strong> {{ $order->shipping_address ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Order Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}</p>
                                    <p><strong>Total Amount:</strong> ${{ number_format($order->total_amount, 2) }}</p>
                                    <p><strong>Payment Status:</strong>
                                        <span
                                            class="badge {{ $order->payment_status == 'paid' ? 'bg-success' : 'bg-warning' }} text-capitalize">
                                            {{ $order->payment_status }}
                                        </span>
                                    </p>
                                    <p><strong>Order Status:</strong>
                                        <span class="badge bg-secondary text-capitalize">{{ $order->status }}</span>
                                    </p>
                                </div>
                            </div>

                            <hr>

                            {{-- Status Update Form --}}
                            <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                                @csrf
                                <div class="row g-3 align-items-center">
                                    <div class="col-md-4">
                                        <label for="payment_status" class="form-label font-weight-bold">Payment
                                            Status:</label>
                                        <select name="payment_status" class="form-select">
                                            <option value="pending"
                                                {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending
                                            </option>
                                            <option value="paid"
                                                {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                                            <option value="failed"
                                                {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                                            <option value="refunded"
                                                {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>Refunded
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="status" class="form-label font-weight-bold">Order Status:</label>
                                        <select name="status" class="form-select">
                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                                                Pending</option>
                                            <option value="processing"
                                                {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>
                                                Shipped (On the way)</option>
                                            <option value="delivered"
                                                {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                            <option value="cancelled"
                                                {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 align-self-end">
                                        <button type="submit" class="btn btn-success w-100">Update Status</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Ordered Products Table --}}
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0">Ordered Items</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th class="text-end" style="text-align: right;">Price</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-end" style="text-align: right;">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- orderItems ব্যবহার করা হয়েছে --}}
                                    @forelse($order->orderItems as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->product->name ?? ($item->product_name ?? 'Product N/A') }}</td>
                                            <td class="text-end" style="text-align: right;">
                                                ${{ number_format($item->price, 2) }}</td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-end" style="text-align: right;">
                                                ${{ number_format($item->price * $item->quantity, 2) }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">No products found for
                                                this order.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            {{-- Accurate Order Financial Calculation Section --}}
                            <div class="row justify-content-end mt-3">
                                <div class="col-md-5">
                                    <ul class="list-group list-group-flush">
                                        {{-- Subtotal Calculation --}}
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <strong>Subtotal:</strong>
                                            <span>${{ number_format($order->subtotal ?? $order->items->sum(fn($item) => $item->price * $item->quantity), 2) }}</span>
                                        </li>

                                        {{-- Coupon Discount (If applied) --}}
                                        @if (!empty($order->discount) || !empty($order->coupon_discount))
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center text-success">
                                                <strong>Discount
                                                    {{ $order->coupon_code ? '(' . $order->coupon_code . ')' : '' }}:</strong>
                                                <span>-${{ number_format($order->discount ?? ($order->coupon_discount ?? 0), 2) }}</span>
                                            </li>
                                        @endif

                                        {{-- Delivery/Shipping Charge --}}
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <strong>Shipping / Delivery Fee:</strong>
                                            <span>+${{ number_format($order->shipping_cost ?? ($order->delivery_charge ?? 0), 2) }}</span>
                                        </li>

                                        {{-- Final Total --}}
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center bg-light font-weight-bold">
                                            <h5 class="mb-0"><strong>Grand Total:</strong></h5>
                                            <h5 class="mb-0 text-primary">
                                                <strong>${{ number_format($order->total_amount ?? $order->total_price, 2) }}</strong>
                                            </h5>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Back to Orders</a>
        </div>
    </div>
@endsection
