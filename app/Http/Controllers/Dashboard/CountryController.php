<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\CountryStoreRequest;
use App\Http\Requests\Dashboard\CountryUpdateRequest;
use App\Models\Country;
use App\Http\Controllers\Controller;

class CountryController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Country::class, 'country');
    }

    public function index()
    {
        return view('dashboard.countries.index')
            ->with('countries', Country::orderBy('id', 'desc')->paginate())
            ->with('total', Country::count())
            ->with('indexUrl', route('dashboard.countries.index'));
    }

    public function jsonCountries()
    {
        return response()->json(Country::all());
    }

    public function create()
    {
        return view('dashboard.countries.create');
    }

    public function store(CountryStoreRequest $request)
    {
        Country::create($request->validated());
        return redirect()->route('dashboard.countries.index')
            ->with('message', trans('crud.success.store'))->with('class', 'alert-success');
    }

    public function show(Country $country)
    {
        return redirect()->route('dashboard.countries.edit', $country['id']);
    }

    public function edit(Country $country)
    {
        return view('dashboard.countries.edit')
            ->with('country', $country);
    }

    public function update(CountryUpdateRequest $request, Country $country)
    {
        $country->update($request->validated());
        return redirect()->route('dashboard.countries.index')
            ->with('message', trans('crud.success.update'))->with('class', 'alert-success');
    }

    public function destroy(Country $country)
    {
        $country->delete();
        return redirect()->route('dashboard.countries.index')
            ->with('message', trans('crud.success.delete'))->with('class', 'alert-success');
    }
}
