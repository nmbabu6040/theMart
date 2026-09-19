<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        return view('admin.setting.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = Setting::first() ?? new Setting();

        $imageFields = [
            'logo',
            'footer_logo',
            'favicon',
            'shop_page_banner',
            'contact_page_banner',
            'default_placeholder',
            'og_image'
        ];

        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                if ($setting->$field && Storage::disk('public')->exists($setting->$field)) {
                    Storage::disk('public')->delete($setting->$field);
                }
                $setting->$field = $request->file($field)->store('settings', 'public');
            }
        }

        $setting->fill($request->except($imageFields));
        $setting->save();

        return redirect()->back()->with('success', 'Site settings updated successfully!');
    }
}
