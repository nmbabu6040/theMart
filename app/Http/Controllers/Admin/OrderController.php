<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        // items এবং items এর সাথে যুক্ত product লোড করা হচ্ছে
        $order = Order::with(['user', 'orderItems.product'])->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:pending,processing,shipped,delivered,cancelled',
            'payment_status' => 'required|string|in:pending,paid,failed,refunded',
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->payment_status = $request->payment_status;
        $order->save();

        return redirect()->back()->with('success', 'Order and Payment status updated successfully!');
    }
}
