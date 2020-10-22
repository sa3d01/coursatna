<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\FacultyStoreRequest;
use App\Http\Requests\Dashboard\FacultyUpdateRequest;
use App\Models\Governorate;
use App\Models\Faculty;
use App\Http\Controllers\Controller;
use App\Models\University;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Faculty::class, 'faculty');
    }

    public function index(University $university)
    {
        return view('dashboard.faculties.index')
            ->with('university', $university)
            ->with('faculties', Faculty::where('university_id', $university->id)->orderBy('id', 'desc')->paginate())
            ->with('total', Faculty::where('university_id', $university->id)->count())
            ->with('indexUrl', route('dashboard.faculties.index', [
                'university' => $university->id,
            ]));
    }

    public function jsonFaculties(Request $request)
    {
        if ($request->has('universityId')) {
            return response()->json(Faculty::where('university_id', $request['universityId'])->get());
        }
        return response()->json(Faculty::all());
    }

    public function create(University $university)
    {
        return view('dashboard.faculties.create')
            ->with('university', $university)
            ->with('governorates', Governorate::all());
    }

    public function store(FacultyStoreRequest $request, University $university)
    {
        $data = $request->validated();
        $data['university_id'] = $university->id;
        $governorate = Governorate::find($request['governorate_id']);
        $data['country_id'] = $governorate['country_id'];

        Faculty::create($data);
        return redirect()->route('dashboard.faculties.index', ['university' => $university->id])
            ->with('message', trans('crud.success.store'))->with('class', 'alert-success');
    }

    public function show(University $university, Faculty $faculty)
    {
        return redirect()
            ->route('dashboard.faculties.edit', ['faculty' => $faculty['id'], 'university' => $university->id]);
    }

    public function edit(University $university, Faculty $faculty)
    {
        return view('dashboard.faculties.edit')
            ->with('university', $university)
            ->with('faculty', $faculty)
            ->with('governorates', Governorate::all());
    }

    public function update(FacultyUpdateRequest $request, University $university, Faculty $faculty)
    {
        $data = $request->validated();
        $data['university_id'] = $university->id;
        $governorate = Governorate::find($request['governorate_id']);
        $data['country_id'] = $governorate['country_id'];

        $faculty->update($data);
        return redirect()->route('dashboard.faculties.index', ['university' => $university->id])
            ->with('message', trans('crud.success.update'))->with('class', 'alert-success');
    }

    public function destroy(University $university, Faculty $faculty)
    {
        $faculty->delete();
        return redirect()->route('dashboard.faculties.index')
            ->with('message', trans('crud.success.delete'))->with('class', 'alert-success');
    }
}
