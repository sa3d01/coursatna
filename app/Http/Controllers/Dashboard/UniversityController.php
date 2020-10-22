<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\UniversityStoreRequest;
use App\Http\Requests\Dashboard\UniversityUpdateRequest;
use App\Models\Governorate;
use App\Models\University;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UniversityController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(University::class, 'university');
    }

    public function index(Request $request)
    {
        if ($request->has('search_q')) {
            $universities = University::where('name', 'LIKE', '%' . $request['search_q'] . '%')
                ->orderBy('id', 'desc')->paginate();
        } else {
            $universities = University::orderBy('id', 'desc')->paginate();
        }
        return view('dashboard.universities.index')
            ->with('universities', $universities)
            ->with('total', University::count())
            ->with('indexUrl', route('dashboard.universities.index'));
    }

    public function jsonUniversities(Request $request)
    {
        if ($request->has('cityId')) {
            return response()->json(University::where('city_id', $request['cityId'])->get());
        }
        if ($request->has('governorateId')) {
            return response()->json(University::where('governorate_id', $request['governorateId'])->get());
        }
        return response()->json(University::all());
    }

    public function create()
    {
        return view('dashboard.universities.create')
            ->with('governorates', Governorate::all());
    }

    public function store(UniversityStoreRequest $request)
    {
        $data = $request->validated();
        $governorate = Governorate::find($request['governorate_id']);
        $data['country_id'] = $governorate['country_id'];
        University::create($data);
        return redirect()->route('dashboard.universities.index')
            ->with('message', trans('crud.success.store'))->with('class', 'alert-success');
    }

    public function show(University $university)
    {
        return redirect()->route('dashboard.universities.edit', $university['id']);
    }

    public function edit(University $university)
    {
        return view('dashboard.universities.edit')
            ->with('university', $university)
            ->with('governorates', Governorate::all());
    }

    public function update(UniversityUpdateRequest $request, University $university)
    {
        $data = $request->validated();
        $governorate = Governorate::find($request['governorate_id']);
        $data['country_id'] = $governorate['country_id'];
        $university->update($data);
        return redirect()->route('dashboard.universities.index')
            ->with('message', trans('crud.success.update'))->with('class', 'alert-success');
    }

    public function destroy(University $university)
    {
        $university->delete();
        return redirect()->route('dashboard.universities.index')
            ->with('message', trans('crud.success.delete'))->with('class', 'alert-success');
    }
}
