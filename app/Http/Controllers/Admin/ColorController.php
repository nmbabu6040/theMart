<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ColorController extends Controller
{
    /**
     * Display all active colors.
     */
    public function index(): View
    {
        $colors = Color::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.colors.index', compact('colors'));
    }


    /**
     * Show create color form.
     */
    public function create(): View
    {
        return view('admin.colors.create');
    }


    /**
     * Store a new color.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                'unique:colors,name',
            ],

            'code' => [
                'required',
                'string',
                'max:20',
                'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/',
                'unique:colors,code',
            ],

            'sort_order' => [
                'required',
                'integer',
                'min:0',
            ],

            'status' => [
                'required',
                'boolean',
            ],
        ]);


        Color::create([
            'name' => trim($validated['name']),
            'code' => strtoupper(trim($validated['code'])),
            'sort_order' => $validated['sort_order'],
            'status' => $validated['status'],
        ]);


        return redirect()
            ->route('colors.index')
            ->with('success', 'Color created successfully.');
    }


    /**
     * Show edit color form.
     */
    public function edit(Color $color): View
    {
        return view('admin.colors.edit', compact('color'));
    }


    /**
     * Update an existing color.
     */
    public function update(
        Request $request,
        Color $color
    ): RedirectResponse {

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('colors', 'name')
                    ->ignore($color->id),
            ],

            'code' => [
                'required',
                'string',
                'max:20',
                'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/',
                Rule::unique('colors', 'code')
                    ->ignore($color->id),
            ],

            'sort_order' => [
                'required',
                'integer',
                'min:0',
            ],

            'status' => [
                'required',
                'boolean',
            ],
        ]);


        $color->update([
            'name' => trim($validated['name']),
            'code' => strtoupper(trim($validated['code'])),
            'sort_order' => $validated['sort_order'],
            'status' => $validated['status'],
        ]);


        return redirect()
            ->route('colors.index')
            ->with('success', 'Color updated successfully.');
    }


    /**
     * Soft delete a color.
     */
    public function destroy(Color $color): RedirectResponse
    {
        $color->delete();

        return redirect()
            ->route('colors.index')
            ->with('success', 'Color moved to trash successfully.');
    }


    /**
     * Display trashed colors.
     */
    public function trash(): View
    {
        $colors = Color::onlyTrashed()
            ->latest('deleted_at')
            ->paginate(15);

        return view('admin.colors.trash', compact('colors'));
    }


    /**
     * Restore a soft-deleted color.
     */
    public function restore(int $id): RedirectResponse
    {
        $color = Color::onlyTrashed()
            ->findOrFail($id);

        $color->restore();

        return redirect()
            ->route('colors.trash')
            ->with('success', 'Color restored successfully.');
    }


    /**
     * Permanently delete a color.
     */
    public function forceDelete(int $id): RedirectResponse
    {
        $color = Color::onlyTrashed()
            ->findOrFail($id);

        $color->forceDelete();

        return redirect()
            ->route('colors.trash')
            ->with('success', 'Color permanently deleted.');
    }
}
