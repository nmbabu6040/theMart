<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InstagramFeed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InstagramFeedController extends Controller
{
    // ১. Read / List
    public function index()
    {
        $feeds = InstagramFeed::latest()->get();
        return view('admin.instagram.index', compact('feeds'));
    }

    // ২. Create View
    public function create()
    {
        return view('admin.instagram.create');
    }

    // ৩. Store / Insert
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'post_url' => 'nullable|url',
        ]);

        $imagePath = $request->file('image')->store('instagram', 'public');

        InstagramFeed::create([
            'image'    => $imagePath,
            'post_url' => $request->post_url,
            'status'   => $request->has('status') ? true : false,
        ]);

        return redirect()->route('instagram.index')->with('success', 'Instagram post added successfully!');
    }

    // ৪. Edit View
    public function edit(InstagramFeed $instagram)
    {
        return view('admin.instagram.edit', compact('instagram'));
    }

    // ৫. Update
    public function update(Request $request, InstagramFeed $instagram)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'post_url' => 'nullable|url',
        ]);

        $imagePath = $instagram->image;

        if ($request->hasFile('image')) {
            if ($instagram->image && Storage::disk('public')->exists($instagram->image)) {
                Storage::disk('public')->delete($instagram->image);
            }
            $imagePath = $request->file('image')->store('instagram', 'public');
        }

        $instagram->update([
            'image'    => $imagePath,
            'post_url' => $request->post_url,
            'status'   => $request->has('status') ? true : false,
        ]);

        return redirect()->route('instagram.index')->with('success', 'Instagram post updated successfully!');
    }

    // ৬. Delete
    public function destroy(InstagramFeed $instagram)
    {
        if ($instagram->image && Storage::disk('public')->exists($instagram->image)) {
            Storage::disk('public')->delete($instagram->image);
        }

        $instagram->delete();

        return redirect()->back()->with('success', 'Instagram post deleted successfully!');
    }
}
