<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TagController extends Controller
{
    /**
     * Display all active tags.
     */
    public function index(): View
    {
        $tags = Tag::latest()->paginate(15);

        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Show create tag form.
     */
    public function create(): View
    {
        return view('admin.tags.create');
    }

    /**
     * Store a new tag.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:tags,name',
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

        $slug = $this->generateUniqueSlug($validated['name']);

        Tag::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'sort_order' => $validated['sort_order'] ?? 0,
            'status' => $request->boolean('status', true),
        ]);

        return redirect()
            ->route('tags.index')
            ->with('success', 'Tag created successfully.');
    }

    /**
     * Show edit tag form.
     */
    public function edit(Tag $tag): View
    {
        return view('admin.tags.edit', compact('tag'));
    }

    /**
     * Update tag.
     */
    public function update(Request $request, Tag $tag): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:tags,name,' . $tag->id,
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

        $slug = $tag->name !== $validated['name']
            ? $this->generateUniqueSlug(
                $validated['name'],
                $tag->id
            )
            : $tag->slug;

        $tag->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'sort_order' => $validated['sort_order'] ?? 0,
            'status' => $request->boolean('status', false),
        ]);

        return redirect()
            ->route('tags.index')
            ->with('success', 'Tag updated successfully.');
    }

    /**
     * Move tag to trash.
     */
    public function destroy(Tag $tag): RedirectResponse
    {
        $tag->delete();

        return redirect()
            ->route('tags.index')
            ->with('success', 'Tag moved to trash successfully.');
    }

    /**
     * Display trashed tags.
     */
    public function trash(): View
    {
        $tags = Tag::onlyTrashed()
            ->latest('deleted_at')
            ->paginate(15);

        return view('admin.tags.trash', compact('tags'));
    }

    /**
     * Restore a trashed tag.
     */
    public function restore(int $id): RedirectResponse
    {
        $tag = Tag::onlyTrashed()->findOrFail($id);

        $tag->restore();

        return redirect()
            ->route('tags.trash')
            ->with('success', 'Tag restored successfully.');
    }

    /**
     * Permanently delete a tag.
     */
    public function forceDelete(int $id): RedirectResponse
    {
        $tag = Tag::onlyTrashed()->findOrFail($id);

        $tag->forceDelete();

        return redirect()
            ->route('tags.trash')
            ->with('success', 'Tag permanently deleted.');
    }

    /**
     * Generate a unique slug.
     */
    private function generateUniqueSlug(
        string $name,
        ?int $ignoreId = null
    ): string {
        $baseSlug = Str::slug($name);

        $slug = $baseSlug;
        $counter = 1;

        while (
            Tag::withTrashed()
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
