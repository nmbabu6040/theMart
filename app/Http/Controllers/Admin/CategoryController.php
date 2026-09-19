<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display all categories.
     */
    public function index(): View
    {
        $categories = Category::latest()->paginate(15);

        return view('admin.categories.index', compact('categories'));
    }


    /**
     * Show create category form.
     */
    public function create(): View
    {
        return view('admin.categories.create');
    }


    /**
     * Store a new category.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:categories,name',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'status' => [
                'required',
                'boolean',
            ],
        ]);


        // Generate unique slug
        $slug = $this->generateUniqueSlug($validated['name']);


        // Upload image
        $imagePath = null;

        if ($request->hasFile('image')) {

            $imagePath = $request
                ->file('image')
                ->store('categories', 'public');
        }


        // Create category
        Category::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'image' => $imagePath,
            'status' => $validated['status'],
        ]);


        return redirect()
            ->route('categories.index')
            ->with('success', 'Category created successfully.');
    }


    /**
     * Show edit category form.
     */
    public function edit(Category $category): View
    {
        return view(
            'admin.categories.edit',
            compact('category')
        );
    }


    /**
     * Update category.
     */
    public function update(
        Request $request,
        Category $category
    ): RedirectResponse {

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:categories,name,' . $category->id,
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
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

        $slug = $category->name !== $validated['name']
            ? $this->generateUniqueSlug(
                $validated['name'],
                $category->id
            )
            : $category->slug;


        /*
        |--------------------------------------------------------------------------
        | Handle New Image
        |--------------------------------------------------------------------------
        */

        $imagePath = $category->image;

        if ($request->hasFile('image')) {

            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }

            $imagePath = $request->file('image')->store(
                'categories',
                'public'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Update Category
        |--------------------------------------------------------------------------
        */

        $category->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'image' => $imagePath,
            'status' => $request->boolean('status', false),
        ]);


        return redirect()
            ->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }


    /**
     * Soft delete category.
     */
    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category moved to trash successfully.');
    }


    /**
     * Display trashed categories.
     */
    public function trash(): View
    {
        $categories = Category::onlyTrashed()
            ->latest('deleted_at')
            ->paginate(15);

        return view(
            'admin.categories.trash',
            compact('categories')
        );
    }


    /**
     * Restore trashed category.
     */
    public function restore(int $id): RedirectResponse
    {
        $category = Category::onlyTrashed()->findOrFail($id);

        $category->restore();

        return redirect()
            ->route('categories.trash')
            ->with('success', 'Category restored successfully.');
    }


    /**
     * Permanently delete category.
     */
    public function forceDelete(int $id): RedirectResponse
    {
        $category = Category::onlyTrashed()->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Delete Category Image
        |--------------------------------------------------------------------------
        */

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }


        /*
        |--------------------------------------------------------------------------
        | Permanent Delete
        |--------------------------------------------------------------------------
        */

        $category->forceDelete();

        return redirect()
            ->route('categories.trash')
            ->with('success', 'Category permanently deleted.');
    }


    /**
     * Generate a unique category slug.
     */
    private function generateUniqueSlug(
        string $name,
        ?int $ignoreId = null
    ): string {

        $baseSlug = Str::slug($name);

        $slug = $baseSlug;
        $counter = 1;


        while (
            Category::withTrashed()
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
