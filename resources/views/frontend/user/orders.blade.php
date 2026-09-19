@extends('frontend.layouts.app')

@section('content')
    <div class="container py-5">
        <h3 class="mb-4">My Orders & Tracking</h3>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th style="text-align: right;">Total Amount</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    <td>#{{ $order->order_number ?? $order->id }}</td>
                                    <td>{{ $order->created_at->format('d M, Y') }}</td>
                                    <td style="text-align: right;">
                                        ${{ number_format($order->total_amount ?? $order->grand_total, 2) }}
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info text-capitalize">
                                            {{ $order->status ?? 'Pending' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        {{-- Modal Trigger Button --}}
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#orderModal{{ $order->id }}">
                                            <i class="ti-eye"></i> View Details & Track
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">No orders found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Links --}}
                <div class="mt-3">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL LOOP (TR এর বাইরে রাখা হয়েছে যাতে HTML Layout Break না করে) --}}
    @foreach ($orders as $order)
        <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content border-0 shadow-lg">


                    <!-- Modal Header -->
                    <div class="modal-header d-flex justify-content-between align-items-center"
                        style="padding: 15px 20px; background-color: #f8f9fa; border-bottom: 1px solid #dee2e6;">
                        <h5 class="modal-title" style="margin: 0; font-weight: 600; font-size: 18px; color: #333;">
                            Order Details - #{{ $order->order_number ?? $order->id }}
                        </h5>

                        <!-- Inline Styling-সহ সমাধান -->
                        <button type="button" data-bs-dismiss="modal" class="btnClose" aria-label="Close"
                            style="">&times;</button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body p-4 text-start">

                        <!-- 1. Tracking Timeline -->
                        <div class="tracking-section mb-4 p-4 bg-light rounded border">
                            <h6 class="fw-bold mb-4 text-start"><i class="ti-truck me-1"></i> Track Order Status</h6>

                            @php
                                $status = strtolower($order->status ?? 'pending');
                            @endphp

                            @if ($status === 'cancelled')
                                <div class="alert alert-danger mb-0 text-center py-3">
                                    <i class="ti-close me-2"></i> This order was <strong>Cancelled</strong>.
                                </div>
                            @else
                                <div class="position-relative my-2">
                                    {{-- Background Line --}}
                                    <div class="progress position-absolute top-50 start-0 translate-middle-y w-100"
                                        style="height: 4px; z-index: 1;">
                                        @php
                                            $progressWidth = '0%';
                                            if ($status === 'processing') {
                                                $progressWidth = '33%';
                                            } elseif ($status === 'shipped') {
                                                $progressWidth = '66%';
                                            } elseif ($status === 'delivered' || $status === 'completed') {
                                                $progressWidth = '100%';
                                            }
                                        @endphp
                                        <div class="progress-bar bg-success" role="progressbar"
                                            style="width: {{ $progressWidth }}; transition: width 0.4s ease;"></div>
                                    </div>

                                    {{-- Steps Icons --}}
                                    <div class="d-flex justify-content-between position-relative" style="z-index: 2;">
                                        <div class="text-center bg-light px-1">
                                            <span
                                                class="badge rounded-circle p-2 {{ in_array($status, ['pending', 'processing', 'shipped', 'delivered', 'completed']) ? 'bg-success text-white' : 'bg-secondary' }}"
                                                style="width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center;">
                                                <i class="ti-shopping-cart"></i>
                                            </span>
                                            <p class="small fw-bold mb-0 mt-2">Order Placed</p>
                                            <span class="text-muted" style="font-size: 11px;">Pending</span>
                                        </div>

                                        <div class="text-center bg-light px-1">
                                            <span
                                                class="badge rounded-circle p-2 {{ in_array($status, ['processing', 'shipped', 'delivered', 'completed']) ? 'bg-success text-white' : 'bg-secondary' }}"
                                                style="width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center;">
                                                <i class="ti-settings"></i>
                                            </span>
                                            <p class="small fw-bold mb-0 mt-2">Processing</p>
                                            <span class="text-muted" style="font-size: 11px;">Packaging</span>
                                        </div>

                                        <div class="text-center bg-light px-1">
                                            <span
                                                class="badge rounded-circle p-2 {{ in_array($status, ['shipped', 'delivered', 'completed']) ? 'bg-success text-white' : 'bg-secondary' }}"
                                                style="width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center;">
                                                <i class="ti-truck"></i>
                                            </span>
                                            <p class="small fw-bold mb-0 mt-2">Shipped</p>
                                            <span class="text-muted" style="font-size: 11px;">On the way</span>
                                        </div>

                                        <div class="text-center bg-light px-1">
                                            <span
                                                class="badge rounded-circle p-2 {{ in_array($status, ['delivered', 'completed']) ? 'bg-success text-white' : 'bg-secondary' }}"
                                                style="width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center;">
                                                <i class="ti-check"></i>
                                            </span>
                                            <p class="small fw-bold mb-0 mt-2">Delivered</p>
                                            <span class="text-muted" style="font-size: 11px;">Completed</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- 2. Summary Info Card -->
                        <div class="p-3 mb-4 rounded bg-light border">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <span class="text-muted small d-block">Order Date:</span>
                                        <strong>{{ $order->created_at->format('d M Y, h:i A') }}</strong>
                                    </div>
                                    <div>
                                        <span class="text-muted small d-block">Payment Status:</span>
                                        <span
                                            class="badge bg-{{ ($order->payment_status ?? '') == 'paid' ? 'success' : 'warning text-dark' }} px-2 py-1">
                                            {{ ucfirst($order->payment_status ?? 'Pending') }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <span class="text-muted small d-block">Shipping Address:</span>
                                        <strong>{{ $order->shipping_address ?? 'N/A' }}</strong>
                                    </div>
                                    <div>
                                        <span class="text-muted small d-block">Grand Total:</span>
                                        <strong
                                            class="text-primary fs-6">${{ number_format($order->total_amount ?? $order->grand_total, 2) }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Ordered Products Table -->
                        <h6 class="fw-bold mb-3 text-dark">Ordered Products</h6>
                        <div class="table-responsive rounded border mb-3">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light border-bottom">
                                    <tr>
                                        <th class="py-2 px-3">Product Name</th>
                                        <th class="py-2 px-3 text-center">Price</th>
                                        <th class="py-2 px-3 text-center">Qty</th>
                                        <th class="py-2 px-3 text-end" style="text-align: right;">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($order->orderItems) && $order->orderItems->count() > 0)
                                        @foreach ($order->orderItems as $item)
                                            <tr>
                                                <td class="py-2 px-3 fw-medium">
                                                    {{ $item->product->name ?? ($item->product_name ?? 'Product N/A') }}
                                                </td>
                                                <td class="py-2 px-3 text-center">
                                                    ${{ number_format($item->price, 2) }}
                                                </td>
                                                <td class="py-2 px-3 text-center">
                                                    {{ $item->quantity }}
                                                </td>
                                                <td class="py-2 px-3 text-end fw-bold" style="text-align: right;">
                                                    ${{ number_format($item->price * $item->quantity, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted">
                                                No item details available.
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <!-- 4. Price Calculation Summary -->
                        <div class="row justify-content-end">
                            <div class="col-md-6">
                                <ul class="list-group list-group-flush">
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center px-0 py-1">
                                        <span>Subtotal:</span>
                                        <span>${{ number_format($order->subtotal ?? $order->orderItems->sum(fn($i) => $i->price * $i->quantity), 2) }}</span>
                                    </li>

                                    @if (!empty($order->discount) || !empty($order->coupon_discount))
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center px-0 py-1 text-success">
                                            <span>Discount
                                                {{ !empty($order->coupon_code) ? '(' . $order->coupon_code . ')' : '' }}:</span>
                                            <span>-${{ number_format($order->discount ?? ($order->coupon_discount ?? 0), 2) }}</span>
                                        </li>
                                    @endif

                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center px-0 py-1">
                                        <span>Shipping Charge:</span>
                                        <span>+${{ number_format($order->shipping_cost ?? ($order->delivery_charge ?? 0), 2) }}</span>
                                    </li>

                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 fw-bold border-top">
                                        <span>Grand Total:</span>
                                        <span
                                            class="text-primary">${{ number_format($order->total_amount ?? $order->grand_total, 2) }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer border-top bg-light px-4 py-2">
                        <button type="button" class="btn btn-secondary btn-sm px-4 d-none"
                            data-bs-dismiss="modal">&times;</button>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
@endsection
@push('style')
    <style>
        /* Modal and Backdrop Stack Order Fix */
        .modal {
            z-index: 99999 !important;
        }

        .modal-backdrop {
            z-index: 99990 !important;
        }

        /* Adds top margin so modal content is properly centered and visible */
        .modal-dialog {
            margin-top: 80px !important;
            margin-bottom: 50px !important;
        }

        .btnclose {
            background: none !important;
            background-color: transparent !important;
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
            font-size: 24px !important;
            font-weight: bold !important;
            line-height: 1 !important;
            color: #000 !important;
            cursor: pointer !important;
            padding: 0 5px !important;
            margin: 0 !important;
            width: auto !important;
            height: auto !important;
            min-width: unset !important;
            min-height: unset !important;
            display: inline-block !important;
        }
    </style>
@endpush

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modals = document.querySelectorAll('.modal');
            modals.forEach(function(modal) {
                document.body.appendChild(modal);
            });
        });
    </script>
@endpush
