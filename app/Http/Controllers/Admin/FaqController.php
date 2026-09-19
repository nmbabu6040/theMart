<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::latest()->get();
        return view('admin.faq.index', compact('faqs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer'   => 'required|string',
        ]);

        Faq::create([
            'question' => $request->question,
            'answer'   => $request->answer,
        ]);

        return redirect()->back()->with('success', 'FAQ added successfully!');
    }

    // Edit Page View
    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        $faqs = Faq::latest()->get(); // টেবিল লিস্টের জন্য
        return view('admin.faq.edit', compact('faq', 'faqs'));
    }

    // Update Action
    public function update(Request $request, $id)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer'   => 'required|string',
        ]);

        $faq = Faq::findOrFail($id);
        $faq->update([
            'question' => $request->question,
            'answer'   => $request->answer,
            'status'   => $request->status ?? 1,
        ]);

        return redirect()->route('faq.index')->with('success', 'FAQ updated successfully!');
    }

    public function destroy($id)
    {
        Faq::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'FAQ deleted successfully!');
    }
}
