<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::latest()->get();
        return view('admin.service.index', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/services'), $imageName);
            $imagePath = 'uploads/services/' . $imageName;
        }

        Service::create([
            'title'       => $request->title,
            'description' => $request->description,
            'image'       => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Service added successfully!');
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        if ($service->image && File::exists(public_path($service->image))) {
            File::delete(public_path($service->image));
        }
        $service->delete();

        return redirect()->back()->with('success', 'Service deleted successfully!');
    }
}
