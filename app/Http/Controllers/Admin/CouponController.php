<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    // ১. কুপন লিস্ট
    public function index()
    {
        $coupons = Coupon::latest()->get();
        return view('admin.coupons.index', compact('coupons'));
    }

    // ২. কুপন তৈরির ফরম
    public function create()
    {
        return view('admin.coupons.create');
    }

    // ৩. কুপন সেভ করা
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:coupons,code',
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:0',
            'min_cart_amount' => 'nullable|numeric|min:0',
            'validity' => 'required|date|after_or_equal:today',
        ]);

        Coupon::create([
            'code' => strtoupper($request->code),
            'type' => $request->type,
            'value' => $request->value,
            'min_cart_amount' => $request->min_cart_amount ?? 0,
            'validity' => $request->validity,
            'status' => $request->status ?? 1,
        ]);

        return redirect()->route('coupons.index')->with('success', 'Coupon Created Successfully!');
    }

    // ৪. কুপন এডিট ফরম
    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupons.edit', compact('coupon'));
    }

    // ৫. কুপন আপডেট করা
    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $request->validate([
            'code' => 'required|unique:coupons,code,' . $coupon->id,
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:0',
            'min_cart_amount' => 'nullable|numeric|min:0',
            'validity' => 'required|date',
        ]);

        $coupon->update([
            'code' => strtoupper($request->code),
            'type' => $request->type,
            'value' => $request->value,
            'min_cart_amount' => $request->min_cart_amount ?? 0,
            'validity' => $request->validity,
            'status' => $request->status ?? 1,
        ]);

        return redirect()->route('coupons.index')->with('success', 'Coupon Updated Successfully!');
    }

    // ৬. স্ট্যাটাস পরিবর্তন (Active/Inactive)
    public function toggleStatus($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->status = !$coupon->status;
        $coupon->save();

        return back()->with('success', 'Coupon Status Updated!');
    }

    // ৭. কুপন মুছে ফেলা (Delete)
    public function destroy($id)
    {
        Coupon::findOrFail($id)->delete();
        return back()->with('success', 'Coupon Deleted Successfully!');
    }
}
