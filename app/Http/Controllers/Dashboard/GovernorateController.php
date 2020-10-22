<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\GovernorateStoreRequest;
use App\Http\Requests\Dashboard\GovernorateUpdateRequest;
use App\Models\Country;
use App\Models\Governorate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GovernorateController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Governorate::class, 'governorate');
    }

    public function index(Country $country)
    {
        return view('dashboard.governorates.index')
            ->with('country', $country)
            ->with('governorates', Governorate::where('country_id', $country->id)->orderBy('id', 'desc')->paginate())
            ->with('total', Governorate::where('country_id', $country->id)->count())
            ->with('indexUrl', route('dashboard.governorates.index'));
    }

    public function jsonGovernorates(Request $request)
    {
        if ($request->has('countryId')) {
            return response()->json(Governorate::where('country_id', $request['countryId'])->get());
        }
        return response()->json(Governorate::all());
    }

    public function create(Country $country)
    {
        return view('dashboard.governorates.create')
            ->with('country', $country);
    }

    public function store(Country $country, GovernorateStoreRequest $request)
    {
        $data = $request->validated();
        $data['country_id'] = $country->id;
        Governorate::create($data);
        return redirect()->route('dashboard.governorates.index', ['country' => $country->id])
            ->with('message', trans('crud.success.store'))->with('class', 'alert-success');
    }

    public function show(Country $country, Governorate $governorate)
    {
        return redirect()
            ->route('dashboard.governorates.edit', ['governorate' => $governorate['id'], 'country' => $country->id]);
    }

    public function edit(Country $country, Governorate $governorate)
    {
        return view('dashboard.governorates.edit')
            ->with('country', $country)
            ->with('governorate', $governorate);
    }

    public function update(Country $country, GovernorateUpdateRequest $request, Governorate $governorate)
    {
        $governorate->update($request->validated());
        return redirect()->route('dashboard.governorates.index', ['country' => $country->id])
            ->with('message', trans('crud.success.update'))->with('class', 'alert-success');
    }

    public function destroy(Country $country, Governorate $governorate)
    {
        $governorate->delete();
        return redirect()->route('dashboard.governorates.index')
            ->with('message', trans('crud.success.delete'))->with('class', 'alert-success');
    }
}
