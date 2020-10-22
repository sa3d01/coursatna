<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\CityStoreRequest;
use App\Http\Requests\Dashboard\CityUpdateRequest;
use App\Models\City;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Governorate;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(City::class, 'city');
    }

    public function index(Country $country, Governorate $governorate)
    {
        return view('dashboard.cities.index')
            ->with('country', $country)
            ->with('governorate', $governorate)
            ->with('cities', City::where([
                'country_id' => $country->id, 'governorate_id' => $governorate->id
            ])->orderBy('id', 'desc')->paginate())
            ->with('total', City::where([
                'country_id' => $country->id, 'governorate_id' => $governorate->id
            ])->count())
            ->with('indexUrl', route('dashboard.cities.index'));
    }

    public function jsonCities(Request $request)
    {
        if ($request->has('countryId')) {
            return response()->json(City::where('country_id', $request['countryId'])->get());
        }
        return response()->json(City::all());
    }

    public function create(Country $country, Governorate $governorate)
    {
        return view('dashboard.cities.create')
            ->with('country', $country)
            ->with('governorate', $governorate);
    }

    public function store(Country $country, Governorate $governorate, CityStoreRequest $request)
    {
        $data = $request->validated();
        $data['country_id'] = $country->id;
        $data['governorate_id'] = $governorate->id;
        City::create($data);
        return redirect()->route('dashboard.cities.index', [
            'country' => $country->id, 'governorate' => $governorate->id
        ])->with('message', trans('crud.success.store'))->with('class', 'alert-success');
    }

    public function show(Country $country, Governorate $governorate, City $city)
    {
        return redirect()
            ->route('dashboard.cities.edit', [
                'country' => $country->id,
                'governorate' => $governorate->id,
                'city' => $city['id'],
            ]);
    }

    public function edit(Country $country, Governorate $governorate, City $city)
    {
        return view('dashboard.cities.edit')
            ->with('country', $country)
            ->with('governorate', $governorate)
            ->with('city', $city);
    }

    public function update(Country $country, Governorate $governorate, CityUpdateRequest $request, City $city)
    {
        $city->update($request->validated());
        return redirect()->route('dashboard.cities.index', [
            'country' => $country->id, 'governorate' => $governorate->id,
        ])->with('message', trans('crud.success.update'))->with('class', 'alert-success');
    }

    public function destroy(Country $country, Governorate $governorate, City $city)
    {
        $city->delete();
        return redirect()->route('dashboard.cities.index')
            ->with('message', trans('crud.success.delete'))->with('class', 'alert-success');
    }
}
