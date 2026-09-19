<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('serial_number', 'asc')->get();
        return view('admin.slider.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.slider.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'nullable|string|max:255',
            'subtitle'      => 'nullable|string|max:255',
            'image'         => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'btn_text'      => 'nullable|string|max:100',
            'btn_link'      => 'nullable|string|max:255',
            'serial_number' => 'nullable|integer',
        ]);

        $imagePath = $request->file('image')->store('sliders', 'public');

        Slider::create([
            'title'         => $request->title,
            'subtitle'      => $request->subtitle,
            'image'         => $imagePath,
            'btn_text'      => $request->btn_text ?? 'Shop Now',
            'btn_link'      => $request->btn_link,
            'status'        => $request->has('status'),
            'serial_number' => $request->serial_number ?? 0,
        ]);

        return redirect()->route('sliders.index')->with('success', 'Slider created successfully!');
    }

    public function edit(Slider $slider)
    {
        return view('admin.slider.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'title'         => 'nullable|string|max:255',
            'subtitle'      => 'nullable|string|max:255',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'btn_text'      => 'nullable|string|max:100',
            'btn_link'      => 'nullable|string|max:255',
            'serial_number' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            if ($slider->image && Storage::disk('public')->exists($slider->image)) {
                Storage::disk('public')->delete($slider->image);
            }
            $slider->image = $request->file('image')->store('sliders', 'public');
        }

        $slider->update([
            'title'         => $request->title,
            'subtitle'      => $request->subtitle,
            'btn_text'      => $request->btn_text ?? 'Shop Now',
            'btn_link'      => $request->btn_link,
            'status'        => $request->has('status'),
            'serial_number' => $request->serial_number ?? 0,
            'image'         => $slider->image,
        ]);

        return redirect()->route('sliders.index')->with('success', 'Slider updated successfully!');
    }

    public function destroy(Slider $slider)
    {
        if ($slider->image && Storage::disk('public')->exists($slider->image)) {
            Storage::disk('public')->delete($slider->image);
        }

        $slider->delete();
        return redirect()->back()->with('success', 'Slider deleted successfully!');
    }
}
