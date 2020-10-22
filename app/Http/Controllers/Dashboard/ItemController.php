<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\ItemStoreRequest;
use App\Http\Requests\Dashboard\ItemUpdateRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\Faculty;
use App\Models\Item;
use App\Models\Level;
use App\Models\Subject;
use App\Models\University;
use App\Models\UniversitySubject;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Item::class, 'item');
    }

    public function index(Request $request)
    {
        if ($request->has('search_q')) {
            $items = Item::where('name', 'LIKE', '%' . $request['search_q'] . '%')->orderBy('id', 'desc')->paginate();
        } else {
            $items = Item::orderBy('id', 'desc')->paginate();
        }
        return view('dashboard.items.index')
            ->with('items', $items)
            ->with('total', Item::count())
            ->with('indexUrl', route('dashboard.items.index'));
    }

    public function create()
    {
        $countries = Country::all();
        $cities = City::where('country_id', $countries->first()->id)->get();
        $universities = University::where('city_id', $cities->first()->id)->get();
        if (count($universities) > 0) {
            $firstUniversityId = $universities->first()->id;

            $faculties = Faculty::where('university_id', $firstUniversityId)->get();
            if (count($faculties) > 0) {
                $firstFacultyId = $faculties->first()->id;
                $universitySubjects = UniversitySubject::where('faculty_id', $firstFacultyId)->get();
            } else {
                $universitySubjects = [];
            }

        } else {
            $faculties = [];
            $universitySubjects = [];
        }
        return view('dashboard.items.create')
            ->with('levels', Level::all())
            ->with('schoolSubjects', Subject::all())
            ->with('countries', $countries)
            ->with('cities', $cities)
            ->with('universities', $universities)
            ->with('faculties', $faculties)
            ->with('universitySubjects', $universitySubjects);
    }

    public function store(ItemStoreRequest $request)
    {
        $data = $request->validated();
        $data['creator_id'] = auth()->id();
        $data['uploader_id'] = auth()->id();
        $data['status'] = 'APPROVED';
        Item::create($data);
        return redirect()->route('dashboard.items.index')
            ->with('message', trans('crud.success.store'))->with('class', 'alert-success');
    }

    public function show(Item $item)
    {
        return redirect()->route('dashboard.items.edit', $item['id']);
    }

    public function viewPdf(Item $item)
    {
        return response()->file(getFilePath($item->file));
    }

    public function edit(Item $item)
    {
        return view('dashboard.items.edit')
            ->with('item', $item)
            ->with('levels', Level::all())
            ->with('schoolSubjects', Subject::all())
            ->with('universitySubjects', UniversitySubject::all());
    }

    public function update(ItemUpdateRequest $request, Item $item)
    {
        $data = $request->validated();
        $data['version'] = $item->version + 1;
        $item->update($data);
        return redirect()->route('dashboard.items.index')
            ->with('message', trans('crud.success.update'))->with('class', 'alert-success');
    }

    public function destroy(Item $item)
    {
        $item->delete();
        return redirect()->route('dashboard.items.index')
            ->with('message', trans('crud.success.delete'))->with('class', 'alert-success');
    }
}
