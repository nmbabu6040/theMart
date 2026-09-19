<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AboutController extends Controller
{
    // Edit Form Show
    public function edit()
    {
        $about = About::first(); // ১ম রো-এর ডাটা নিয়ে আসবে
        return view('admin.about.edit', compact('about'));
    }

    // Update Data & Image
    public function update(Request $request)
    {
        $request->validate([
            'sub_title'   => 'nullable|string|max:255',
            'title'       => 'nullable|string',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $about = About::first() ?? new About();

        // Image Upload Logic
        if ($request->hasFile('image')) {
            // আগের ছবি থাকলে ডিলিট করবে
            if ($about->image && File::exists(public_path($about->image))) {
                File::delete(public_path($about->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/about'), $imageName);
            $about->image = 'uploads/about/' . $imageName;
        }

        $about->sub_title   = $request->sub_title;
        $about->title       = $request->title;
        $about->description = $request->description;
        $about->save();

        return redirect()->back()->with('success', 'About section updated successfully!');
    }
}
