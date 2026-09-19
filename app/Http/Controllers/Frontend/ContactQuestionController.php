<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactQuestion;
use App\Models\Setting;
use Illuminate\Http\Request;

class ContactQuestionController extends Controller
{
    // Contact Page render
    public function index()
    {
        $settings = Setting::all();
        return view('frontend.home.contact', compact('settings')); // আপনার blade ফাইলের সঠিক নাম/পাথ নিশ্চিত করুন
    }

    // Submit request handling
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'adress'  => 'nullable|string|max:255',
            'service' => 'nullable|string|max:255',
            'note'    => 'required|string',
        ]);

        ContactQuestion::create([
            'name'    => $validated['name'],
            'email'   => $validated['email'],
            'address' => $request->adress, // HTML input name 'adress' -> Database column 'address'
            'service' => $request->service,
            'note'    => $validated['note'],
        ]);

        return redirect()->back()->with('success', 'Your question has been submitted successfully!');
    }
}
