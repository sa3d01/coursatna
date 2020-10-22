<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\MajorStoreRequest;
use App\Http\Requests\Dashboard\MajorUpdateRequest;
use App\Models\Faculty;
use App\Models\Major;
use App\Http\Controllers\Controller;
use App\Models\University;
use Illuminate\Http\Request;

class MajorController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Major::class, 'major');
    }

    public function index(University $university, Faculty $faculty)
    {
        return view('dashboard.majors.index')
            ->with('university', $university)
            ->with('faculty', $faculty)
            ->with('majors', Major::where(['faculty_id' => $faculty->id])->orderBy('id', 'desc')->paginate())
            ->with('total', Major::where(['faculty_id' => $faculty->id])->count())
            ->with('indexUrl', route('dashboard.majors.index', [
                'university' => $university->id,
                'faculty' => $faculty->id,
            ]));
    }

    public function jsonMajors(Request $request)
    {
        if ($request->has('facultyId')) {
            return response()->json(Major::where('faculty_id', $request['facultyId'])->get());
        }
        return response()->json(Major::all());
    }

    public function create(University $university, Faculty $faculty)
    {
        return view('dashboard.majors.create')
            ->with('university', $university)
            ->with('faculty', $faculty);
    }

    public function store(University $university, Faculty $faculty, MajorStoreRequest $request)
    {
        $data = $request->validated();
        $data['university_id'] = $university->id;
        $data['faculty_id'] = $faculty->id;
        Major::create($data);
        return redirect()->route('dashboard.majors.index', [
            'university' => $university->id, 'faculty' => $faculty->id
        ])->with('message', trans('crud.success.store'))->with('class', 'alert-success');
    }

    public function show(University $university, Faculty $faculty, Major $major)
    {
        return redirect()
            ->route('dashboard.majors.edit', [
                'university' => $university->id,
                'faculty' => $faculty->id,
                'major' => $major['id'],
            ]);
    }

    public function edit(University $university, Faculty $faculty, Major $major)
    {
        return view('dashboard.majors.edit')
            ->with('university', $university)
            ->with('faculty', $faculty)
            ->with('major', $major);
    }

    public function update(University $university, Faculty $faculty, MajorUpdateRequest $request, Major $major)
    {
        $major->update($request->validated());
        return redirect()->route('dashboard.majors.index', [
            'university' => $university->id, 'faculty' => $faculty->id,
        ])->with('message', trans('crud.success.update'))->with('class', 'alert-success');
    }

    public function destroy(University $university, Faculty $faculty, Major $major)
    {
        $major->delete();
        return redirect()->route('dashboard.majors.index')
            ->with('message', trans('crud.success.delete'))->with('class', 'alert-success');
    }
}
