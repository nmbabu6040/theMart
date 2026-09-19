<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SubCategoryController extends Controller
{
    /**
     * Display all sub-categories.
     */
    public function index(): View
    {
        $subCategories = SubCategory::with('category')
            ->latest()
            ->paginate(15);

        return view('admin.sub_categories.index', compact('subCategories'));
    }

    /**
     * Show create sub-category form.
     */
    public function create(): View
    {
        $categories = Category::query()
            ->where('status', true)
            ->orderBy('name')
            ->get();

        return view('admin.sub_categories.create', compact('categories'));
    }

    /**
     * Store a new sub-category.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
                'unique:sub_categories,name',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
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

        $imagePath = null;

        DB::beginTransaction();

        try {
            /*
            |--------------------------------------------------------------------------
            | Generate Unique Slug
            |--------------------------------------------------------------------------
            */

            $slug = $this->generateUniqueSlug(
                $validated['slug'] ?? $validated['name']
            );

            /*
            |--------------------------------------------------------------------------
            | Upload Image
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store(
                    'sub-categories',
                    'public'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Create Sub-Category
            |--------------------------------------------------------------------------
            */

            SubCategory::create([
                'category_id' => $validated['category_id'],
                'name' => $validated['name'],
                'slug' => $slug,
                'image' => $imagePath,
                'sort_order' => $validated['sort_order'] ?? 0,
                'status' => $request->boolean('status', true),
            ]);

            DB::commit();

            return redirect()
                ->route('sub-categories.index')
                ->with('success', 'Sub-category created successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();

            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }

            report($e);

            return back()
                ->withInput()
                ->with('error', 'Something went wrong while creating the sub-category.');
        }
    }

    /**
     * Show edit sub-category form.
     */
    public function edit(SubCategory $subCategory): View
    {
        $categories = Category::query()
            ->where('status', true)
            ->orderBy('name')
            ->get();

        return view(
            'admin.sub_categories.edit',
            compact('subCategory', 'categories')
        );
    }

    /**
     * Update sub-category.
     */
    public function update(
        Request $request,
        SubCategory $subCategory
    ): RedirectResponse {
        $validated = $request->validate([
            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
                'unique:sub_categories,name,' . $subCategory->id,
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
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

        $oldImage = $subCategory->image;
        $newImagePath = null;

        DB::beginTransaction();

        try {
            /*
            |--------------------------------------------------------------------------
            | Generate Unique Slug
            |--------------------------------------------------------------------------
            */

            $slugSource = $validated['slug'] ?? $validated['name'];

            $slug = $this->generateUniqueSlug(
                $slugSource,
                $subCategory->id
            );

            /*
            |--------------------------------------------------------------------------
            | Handle New Image
            |--------------------------------------------------------------------------
            */

            $imagePath = $subCategory->image;

            if ($request->hasFile('image')) {
                $newImagePath = $request->file('image')->store(
                    'sub-categories',
                    'public'
                );

                $imagePath = $newImagePath;
            }

            /*
            |--------------------------------------------------------------------------
            | Update Sub-Category
            |--------------------------------------------------------------------------
            */

            $subCategory->update([
                'category_id' => $validated['category_id'],
                'name' => $validated['name'],
                'slug' => $slug,
                'image' => $imagePath,
                'sort_order' => $validated['sort_order'] ?? 0,
                'status' => $request->boolean('status', false),
            ]);

            DB::commit();

            /*
            |--------------------------------------------------------------------------
            | Delete Old Image
            |--------------------------------------------------------------------------
            */

            if ($newImagePath && $oldImage) {
                Storage::disk('public')->delete($oldImage);
            }

            return redirect()
                ->route('sub-categories.index')
                ->with('success', 'Sub-category updated successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();

            if ($newImagePath) {
                Storage::disk('public')->delete($newImagePath);
            }

            report($e);

            return back()
                ->withInput()
                ->with('error', 'Something went wrong while updating the sub-category.');
        }
    }

    /**
     * Soft delete sub-category.
     */
    public function destroy(SubCategory $subCategory): RedirectResponse
    {
        $subCategory->delete();

        return redirect()
            ->route('sub-categories.index')
            ->with('success', 'Sub-category moved to trash successfully.');
    }

    /**
     * Display trashed sub-categories.
     */
    public function trash(): View
    {
        $subCategories = SubCategory::onlyTrashed()
            ->with('category')
            ->latest('deleted_at')
            ->paginate(15);

        return view(
            'admin.sub_categories.trash',
            compact('subCategories')
        );
    }

    /**
     * Restore a trashed sub-category.
     */
    public function restore(int $id): RedirectResponse
    {
        $subCategory = SubCategory::onlyTrashed()
            ->findOrFail($id);

        $subCategory->restore();

        return redirect()
            ->route('sub-categories.trash')
            ->with('success', 'Sub-category restored successfully.');
    }

    /**
     * Permanently delete sub-category.
     */
    public function forceDelete(int $id): RedirectResponse
    {
        $subCategory = SubCategory::onlyTrashed()
            ->findOrFail($id);

        DB::beginTransaction();

        try {
            /*
            |--------------------------------------------------------------------------
            | Delete Image
            |--------------------------------------------------------------------------
            */

            if ($subCategory->image) {
                Storage::disk('public')->delete($subCategory->image);
            }

            /*
            |--------------------------------------------------------------------------
            | Permanently Delete
            |--------------------------------------------------------------------------
            */

            $subCategory->forceDelete();

            DB::commit();

            return redirect()
                ->route('sub-categories.trash')
                ->with('success', 'Sub-category permanently deleted.');
        } catch (\Throwable $e) {
            DB::rollBack();

            report($e);

            return back()
                ->with('error', 'Something went wrong while deleting the sub-category.');
        }
    }

    /**
     * Generate a unique slug.
     */
    private function generateUniqueSlug(
        string $value,
        ?int $ignoreId = null
    ): string {
        $baseSlug = Str::slug($value);

        if ($baseSlug === '') {
            $baseSlug = 'sub-category';
        }

        $slug = $baseSlug;
        $counter = 1;

        while (
            SubCategory::withTrashed()
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
