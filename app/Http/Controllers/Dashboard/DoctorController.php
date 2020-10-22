<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\DoctorStoreRequest;
use App\Http\Requests\Dashboard\DoctorUpdateRequest;
use App\Models\City;
use App\Models\Faculty;
use App\Models\University;
use App\Models\User;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;

class DoctorController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'doctor');
    }

    public function index()
    {
        return view('dashboard.doctors.index')
            ->with('doctors', User::orderBy('id', 'DESC')->role('UNIVERSITY_DOCTOR')->paginate())
            ->with('total', User::role('UNIVERSITY_DOCTOR')->count())
            ->with('indexUrl', route('dashboard.doctors.index'));
    }

    public function create()
    {
        $cities = City::where(['country_id' => 1])->get();
        $universities = count($cities) > 0 ? University::where(['city_id' => $cities->first()->id])->get() : [];
        $faculties = count($universities) > 0 ? Faculty::where(['university_id' => $universities->first()->id])->get() : [];
        return view('dashboard.doctors.create')
            ->with('cities', $cities)
            ->with('universities', $universities)
            ->with('faculties', $faculties);
    }

    public function store(DoctorStoreRequest $request)
    {
        $doctor = User::create($request->validated());
        $role = Role::findByName('UNIVERSITY_DOCTOR');
        if ($role) {
            $doctor->syncRoles(['UNIVERSITY_DOCTOR']);
        }
        return redirect()->route('dashboard.doctors.index')
            ->with('message', trans('crud.success.store'))->with('class', 'alert-success');
    }

    public function show(User $doctor)
    {
        return redirect()->route('dashboard.doctors.edit', $doctor['id']);
    }

    public function edit(User $doctor)
    {
        $cities = City::where(['country_id' => 1])->get();
        $universities = count($cities) > 0 ? University::where(['city_id' => $doctor->city_id])->get() : [];
        $faculties = count($universities) > 0 ? Faculty::where(['university_id' => $doctor->university_id])->get() : [];
        return view('dashboard.doctors.edit')
            ->with('doctor', $doctor)
            ->with('cities', $cities)
            ->with('universities', $universities)
            ->with('faculties', $faculties);
    }

    public function update(DoctorUpdateRequest $request, User $doctor)
    {
        $data = $request->only(['city_id', 'university_id', 'name', 'email']);
        if ($request->has('password')) {
            $data['password'] = $request['password'];
        }
        if ($request->has('avatar')) {
            $data['avatar'] = $request['avatar'];
        }
        $doctor->update($data);
        return redirect()->route('dashboard.doctors.index')
            ->with('message', trans('crud.success.update'))->with('class', 'alert-success');
    }

    public function destroy(User $doctor)
    {
        $doctor->delete();
        return response()->json(['message' => 'Deleted Successfully'], 200);
    }
}
