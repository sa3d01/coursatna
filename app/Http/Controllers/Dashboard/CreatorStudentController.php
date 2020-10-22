<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CreatorStudentStoreRequest;
use App\Http\Requests\Dashboard\CreatorStudentUpdateRequest;
use App\Models\City;
use App\Models\CreatorStudentRequest;
use App\Models\Faculty;
use App\Models\Governorate;
use App\Models\University;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CreatorStudentsExport;

class CreatorStudentController extends Controller
{
    public function requests()
    {
        return view('dashboard.creator-students.requests')
            ->with('creatorStudentRequests', CreatorStudentRequest::where('status', 'PENDING')
                ->orderBy('id', 'desc')->paginate())
            ->with('total', CreatorStudentRequest::where('status', 'PENDING')->count());
    }

    public function index(Request $request)
    {
        $search_q = '';
        if ($request->has('search_q')) {
            $search_q = $request['search_q'];
        }

        $where = [];
        if ($request->has('majorId')) {
            $where['major_id'] = $request['majorId'];
        }
        if ($request->has('facultyId')) {
            $where['faculty_id'] = $request['facultyId'];
        }
        if ($request->has('universityId')) {
            $where['university_id'] = $request['universityId'];
        }
        if ($request->has('governorateId')) {
            $where['governorate_id'] = $request['governorateId'];
        }
        $creatorStudents = User::role('UNIVERSITY_CREATOR_STUDENT')
            ->where($where)
            ->where('name', 'LIKE', '%' . $search_q . '%')
            ->orderBy('id', 'DESC')
            ->paginate();

        return view('dashboard.creator-students.index')
            ->with('creatorStudents', $creatorStudents)
            ->with('total', $creatorStudents->total())
            ->with('indexUrl', route('dashboard.creator-students.index'));
    }

    public function export(Request $request)
    {
        $fileName = 'creatorstudents' . time();
        return Excel::download(new CreatorStudentsExport($this->buildingWhereQuery($request->all())), $fileName . '.xlsx');
    }

    private function buildingWhereQuery($dataArray)
    {
        $where = [];
        if (array_key_exists('majorId', $dataArray)) {
            $where['major_id'] = $dataArray['majorId'];
        }
        if (array_key_exists('facultyId', $dataArray)) {
            $where['faculty_id'] = $dataArray['facultyId'];
        }
        if (array_key_exists('universityId', $dataArray)) {
            $where['university_id'] = $dataArray['universityId'];
        }
        if (array_key_exists('governorateId', $dataArray)) {
            $where['governorate_id'] = $dataArray['governorateId'];
        }
        return $where;
    }

    public function create()
    {
        $governorates = Governorate::where(['country_id' => 1])->get();
        $universities = count($governorates) > 0 ? University::where(['governorate_id' => $governorates->first()->id])->get() : [];
        $faculties = count($universities) > 0 ? Faculty::where(['university_id' => $universities->first()->id])->get() : [];
        return view('dashboard.creator-students.create')
            ->with('governorates', $governorates)
            ->with('universities', $universities)
            ->with('faculties', $faculties);
    }

    public function store(CreatorStudentStoreRequest $request)
    {
        $creatorStudent = User::create($request->validated());
        $role = Role::findByName('UNIVERSITY_CREATOR_STUDENT');
        if ($role) {
            $creatorStudent->syncRoles(['UNIVERSITY_CREATOR_STUDENT']);
        }
        return redirect()->route('dashboard.creator-students.index')
            ->with('message', trans('crud.success.store'))->with('class', 'alert-success');
    }

    public function show(User $creatorStudent)
    {
        return redirect()->route('dashboard.creator-students.edit', $creatorStudent['id']);
    }

    public function edit(User $creatorStudent)
    {
        $cities = City::where(['country_id' => 1])->get();
        $universities = count($cities) > 0 ? University::where(['city_id' => $creatorStudent->city_id])->get() : [];
        $faculties = count($universities) > 0 ? Faculty::where(['university_id' => $creatorStudent->university_id])->get() : [];
        return view('dashboard.creator-students.edit')
            ->with('creatorStudent', $creatorStudent)
            ->with('cities', $cities)
            ->with('universities', $universities)
            ->with('faculties', $faculties);
    }

    public function update(CreatorStudentUpdateRequest $request, User $creatorStudent)
    {
        $data = $request->only(['city_id', 'university_id', 'name', 'email']);
        if ($request->has('password')) {
            $data['password'] = $request['password'];
        }
        $creatorStudent->update($data);
        return redirect()->route('dashboard.creator-students.index')
            ->with('message', trans('crud.success.update'))->with('class', 'alert-success');
    }

    public function destroy(User $creatorStudent)
    {
        $creatorStudent->delete();
        return response()->json(['message' => 'Deleted Successfully'], 200);
    }
}
