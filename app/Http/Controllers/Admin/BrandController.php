<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BrandController extends Controller
{
    /**
     * Display all brands.
     */
    public function index(): View
    {
        $brands = Brand::latest()->paginate(15);

        return view('admin.brands.index', compact('brands'));
    }

    /**
     * Show create brand form.
     */
    public function create(): View
    {
        return view('admin.brands.create');
    }

    /**
     * Store a new brand.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:brands,name',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:brands,slug',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'status' => [
                'nullable',
                'boolean',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Generate Unique Slug
        |--------------------------------------------------------------------------
        */

        $slug = $this->generateUniqueSlug(
            $validated['slug'] ?: $validated['name']
        );

        /*
        |--------------------------------------------------------------------------
        | Upload Image
        |--------------------------------------------------------------------------
        */

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store(
                'brands',
                'public'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Create Brand
        |--------------------------------------------------------------------------
        */

        Brand::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'image' => $imagePath,
            'sort_order' => $validated['sort_order'] ?? 0,
            'status' => $request->boolean('status', true),
        ]);

        return redirect()
            ->route('brands.index')
            ->with('success', 'Brand created successfully.');
    }

    /**
     * Show edit brand form.
     */
    public function edit(Brand $brand): View
    {
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Update brand.
     */
    public function update(
        Request $request,
        Brand $brand
    ): RedirectResponse {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:brands,name,' . $brand->id,
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:brands,slug,' . $brand->id,
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'status' => [
                'nullable',
                'boolean',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Generate Slug
        |--------------------------------------------------------------------------
        */

        $slug = $this->generateUniqueSlug(
            $validated['slug'] ?: $validated['name'],
            $brand->id
        );

        /*
        |--------------------------------------------------------------------------
        | Handle Image
        |--------------------------------------------------------------------------
        */

        $imagePath = $brand->image;

        if ($request->hasFile('image')) {

            if ($brand->image) {
                Storage::disk('public')->delete($brand->image);
            }

            $imagePath = $request->file('image')->store(
                'brands',
                'public'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Update Brand
        |--------------------------------------------------------------------------
        */

        $brand->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'image' => $imagePath,
            'sort_order' => $validated['sort_order'] ?? 0,
            'status' => $request->boolean('status', false),
        ]);

        return redirect()
            ->route('brands.index')
            ->with('success', 'Brand updated successfully.');
    }

    /**
     * Move brand to trash.
     */
    public function destroy(Brand $brand): RedirectResponse
    {
        $brand->delete();

        return redirect()
            ->route('brands.index')
            ->with('success', 'Brand moved to trash successfully.');
    }

    /**
     * Display trashed brands.
     */
    public function trash(): View
    {
        $brands = Brand::onlyTrashed()
            ->latest('deleted_at')
            ->paginate(15);

        return view('admin.brands.trash', compact('brands'));
    }

    /**
     * Restore trashed brand.
     */
    public function restore(int $id): RedirectResponse
    {
        $brand = Brand::onlyTrashed()->findOrFail($id);

        $brand->restore();

        return redirect()
            ->route('brands.trash')
            ->with('success', 'Brand restored successfully.');
    }

    /**
     * Permanently delete brand.
     */
    public function forceDelete(int $id): RedirectResponse
    {
        $brand = Brand::onlyTrashed()->findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Delete Brand Image
        |--------------------------------------------------------------------------
        */

        if ($brand->image) {
            Storage::disk('public')->delete($brand->image);
        }

        /*
        |--------------------------------------------------------------------------
        | Permanent Delete
        |--------------------------------------------------------------------------
        */

        $brand->forceDelete();

        return redirect()
            ->route('brands.trash')
            ->with('success', 'Brand permanently deleted.');
    }

    /**
     * Generate a unique slug.
     */
    private function generateUniqueSlug(
        string $value,
        ?int $ignoreId = null
    ): string {
        $baseSlug = Str::slug($value);

        // Fallback if slug becomes empty.
        if ($baseSlug === '') {
            $baseSlug = 'brand';
        }

        $slug = $baseSlug;
        $counter = 1;

        while (
            Brand::withTrashed()
            ->when(
                $ignoreId,
                fn($query) => $query->where('id', '!=', $ignoreId)
            )
            ->where('slug', $slug)
            ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
