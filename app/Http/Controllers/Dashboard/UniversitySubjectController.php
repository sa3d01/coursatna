<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\UniversitySubjectStoreRequest;
use App\Http\Requests\Dashboard\UniversitySubjectUpdateRequest;
use App\Models\Faculty;
use App\Models\Level;
use App\Models\Major;
use App\Models\University;
use App\Models\UniversitySubject;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UniversitySubjectController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(UniversitySubject::class, 'university_subject');
    }

    public function index(Request $request, University $university, Faculty $faculty)
    {
        if ($request->has('search_q')) {
            $universitySubjects = UniversitySubject::where(['faculty_id' => $faculty->id])
                ->where('name', 'LIKE', '%' . $request['search_q'] . '%')->orderBy('id', 'desc')->paginate();
        } else {
            $universitySubjects = UniversitySubject::where(['faculty_id' => $faculty->id])
                ->orderBy('id', 'desc')->paginate();
        }
        return view('dashboard.university-subjects.index')
            ->with('university', $university)
            ->with('faculty', $faculty)
            ->with('universitySubjects', $universitySubjects)
            ->with('total', UniversitySubject::where(['faculty_id' => $faculty->id])->count())
            ->with('indexUrl', route('dashboard.university-subjects.index', [
                'university' => $university->id,
                'faculty' => $faculty->id,
            ]));
    }

    public function jsonUniversitySubjects(Request $request)
    {
        if ($request->has('universityId')) {
            return response()->json(UniversitySubject::where('university_id', $request['universityId'])->get());
        }
        if ($request->has('facultyId')) {
            return response()->json(UniversitySubject::where('faculty_id', $request['facultyId'])->get());
        }
        return response()->json(UniversitySubject::all());
    }

    public function create(University $university, Faculty $faculty)
    {
        return view('dashboard.university-subjects.create')
            ->with('majors', Major::where(['faculty_id' => $faculty->id])->get())
            ->with('levels', Level::where(['type' => 'UNIVERSITY'])->get())
            ->with('university', $university)
            ->with('faculty', $faculty);
    }

    public function store(University $university, Faculty $faculty, UniversitySubjectStoreRequest $request)
    {
        $data = $request->validated();
        $data['faculty_id'] = $faculty->id;
        UniversitySubject::create($data);
        return redirect()->route('dashboard.university-subjects.index', [
            'university' => $university->id, 'faculty' => $faculty->id
        ])->with('message', trans('crud.success.store'))->with('class', 'alert-success');
    }

    public function show(University $university, Faculty $faculty, UniversitySubject $universitySubject)
    {
        return redirect()
            ->route('dashboard.university-subjects.edit', [
                'university' => $university->id,
                'faculty' => $faculty->id,
                'university-subject' => $universitySubject['id'],
            ]);
    }

    public function edit(University $university, Faculty $faculty, UniversitySubject $universitySubject)
    {
        return view('dashboard.university-subjects.edit')
            ->with('majors', Major::where(['faculty_id' => $faculty->id])->get())
            ->with('levels', Level::where(['type' => 'UNIVERSITY'])->get())
            ->with('university', $university)
            ->with('faculty', $faculty)
            ->with('universitySubject', $universitySubject);
    }

    public function update(University $university, Faculty $faculty, UniversitySubjectUpdateRequest $request, UniversitySubject $universitySubject)
    {
        $universitySubject->update($request->validated());
        return redirect()->route('dashboard.university-subjects.index', [
            'university' => $university->id, 'faculty' => $faculty->id,
        ])->with('message', trans('crud.success.update'))->with('class', 'alert-success');
    }

    public function destroy(University $university, Faculty $faculty, UniversitySubject $universitySubject)
    {
        $universitySubject->delete();
        return redirect()->route('dashboard.university-subjects.index')
            ->with('message', trans('crud.success.delete'))->with('class', 'alert-success');
    }
}
