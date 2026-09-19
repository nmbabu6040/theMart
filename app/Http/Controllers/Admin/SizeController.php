<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SizeController extends Controller
{
    /**
     * Display all active sizes.
     */
    public function index(): View
    {
        $sizes = Size::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(10);

        return view('admin.sizes.index', compact('sizes'));
    }


    /**
     * Show create size form.
     */
    public function create(): View
    {
        return view('admin.sizes.create');
    }


    /**
     * Store a new size.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                'unique:sizes,name',
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


        Size::create([
            'name' => trim($validated['name']),
            'sort_order' => $validated['sort_order'],
            'status' => $validated['status'],
        ]);


        return redirect()
            ->route('sizes.index')
            ->with('success', 'Size created successfully.');
    }


    /**
     * Show edit size form.
     */
    public function edit(Size $size): View
    {
        return view('admin.sizes.edit', compact('size'));
    }


    /**
     * Update an existing size.
     */
    public function update(Request $request, Size $size): RedirectResponse
    {

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('sizes', 'name')
                    ->ignore($size->id),
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


        $size->update([
            'name' => trim($validated['name']),
            'sort_order' => $validated['sort_order'],
            'status' => $validated['status'],
        ]);


        return redirect()
            ->route('sizes.index')
            ->with('success', 'Size updated successfully.');
    }


    /**
     * Soft delete a size.
     */
    public function destroy(Size $size): RedirectResponse
    {
        $size->delete();

        return redirect()
            ->route('sizes.index')
            ->with('success', 'Size moved to trash successfully.');
    }


    /**
     * Display trashed sizes.
     */
    public function trash(): View
    {
        $sizes = Size::onlyTrashed()
            ->orderByDesc('deleted_at')
            ->paginate(15);

        return view('admin.sizes.trash', compact('sizes'));
    }


    /**
     * Restore a soft-deleted size.
     */
    public function restore(int $id): RedirectResponse
    {
        $size = Size::onlyTrashed()->findOrFail($id);

        $size->restore();

        return redirect()
            ->route('sizes.trash')
            ->with('success', 'Size restored successfully.');
    }


    /**
     * Permanently delete a size.
     */
    public function forceDelete(int $id): RedirectResponse
    {
        $size = Size::onlyTrashed()->findOrFail($id);

        $size->forceDelete();

        return redirect()
            ->route('sizes.trash')
            ->with('success', 'Size permanently deleted.');
    }
}
