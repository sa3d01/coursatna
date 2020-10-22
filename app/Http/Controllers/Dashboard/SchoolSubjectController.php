<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\SchoolSubjectStoreRequest;
use App\Http\Requests\Dashboard\SchoolSubjectUpdateRequest;
use App\Models\Level;
use App\Models\Subject;
use App\Http\Controllers\Controller;

class SchoolSubjectController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Subject::class, 'school_subject');
    }

    public function index()
    {
        return view('dashboard.school-subjects.index')
            ->with('schoolSubjects', Subject::orderBy('id', 'desc')->paginate())
            ->with('total', Subject::count())
            ->with('indexUrl', route('dashboard.school-subjects.index'));
    }

    public function create()
    {
        return view('dashboard.school-subjects.create')
            ->with('levels', Level::where('type', 'SCHOOL')->get());
    }

    public function store(SchoolSubjectStoreRequest $request)
    {
        Subject::create($request->validated());
        return redirect()->route('dashboard.school-subjects.index')
            ->with('message', trans('crud.success.store'))->with('class', 'alert-success');
    }

    public function show(Subject $schoolSubject)
    {
        return redirect()->route('dashboard.school-subjects.edit', $schoolSubject['id']);
    }

    public function edit(Subject $schoolSubject)
    {
        return view('dashboard.school-subjects.edit')
            ->with('schoolSubject', $schoolSubject)
            ->with('levels', Level::where('type', 'SCHOOL')->get());
    }

    public function update(SchoolSubjectUpdateRequest $request, Subject $schoolSubject)
    {
        $schoolSubject->update($request->validated());
        return redirect()->route('dashboard.school-subjects.index')
            ->with('message', trans('crud.success.update'))->with('class', 'alert-success');
    }

    public function destroy(Subject $schoolSubject)
    {
        $schoolSubject->delete();
        return redirect()->route('dashboard.school-subjects.index')
            ->with('message', trans('crud.success.delete'))->with('class', 'alert-success');
    }
}
