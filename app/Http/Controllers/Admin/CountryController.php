<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CountryController extends Controller
{
    /**
     * Display all countries.
     */
    public function index()
    {
        $countries = Country::latest()->get();

        return view('admin.countries.index', compact('countries'));
    }

    /**
     * Show create country form.
     */
    public function create()
    {
        return view('admin.countries.create');
    }

    /**
     * Store new country.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:countries,name',
            ],
            'code' => [
                'nullable',
                'string',
                'max:5',
            ],
        ]);

        Country::create([
            'name' => $validated['name'],
            'code' => !empty($validated['code'])
                ? strtoupper($validated['code'])
                : null,
        ]);

        return redirect()
            ->route('countries.index')
            ->with('success', 'Country added successfully!');
    }

    /**
     * Show edit country form.
     */
    public function edit(Country $country)
    {
        return view('admin.countries.edit', compact('country'));
    }

    /**
     * Update country.
     */
    public function update(Request $request, Country $country)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('countries', 'name')
                    ->ignore($country->id),
            ],
            'code' => [
                'nullable',
                'string',
                'max:5',
            ],
        ]);

        $country->update([
            'name' => $validated['name'],
            'code' => !empty($validated['code'])
                ? strtoupper($validated['code'])
                : null,
        ]);

        return redirect()
            ->route('countries.index')
            ->with('success', 'Country updated successfully!');
    }

    /**
     * Delete country.
     */
    public function destroy(Country $country)
    {
        $country->delete();

        return redirect()
            ->route('countries.index')
            ->with('success', 'Country deleted successfully!');
    }
}
