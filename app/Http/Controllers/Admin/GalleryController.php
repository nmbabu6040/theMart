<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->get();
        return view('admin.gallery.index', compact('galleries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/gallery'), $imageName);

            Gallery::create([
                'title' => $request->title,
                'image' => 'uploads/gallery/' . $imageName,
            ]);
        }

        return redirect()->back()->with('success', 'Image uploaded to gallery!');
    }

    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);
        if ($gallery->image && File::exists(public_path($gallery->image))) {
            File::delete(public_path($gallery->image));
        }
        $gallery->delete();

        return redirect()->back()->with('success', 'Image deleted successfully!');
    }
}
