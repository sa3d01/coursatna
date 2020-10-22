<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\FieldStoreRequest;
use App\Http\Requests\Dashboard\FieldUpdateRequest;
use App\Models\Field;
use App\Http\Controllers\Controller;

class FieldController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Field::class, 'field');
    }

    public function index()
    {
        return view('dashboard.fields.index')
            ->with('fields', Field::orderBy('id', 'desc')->paginate())
            ->with('total', Field::count())
            ->with('indexUrl', route('dashboard.fields.index'));
    }

    public function create()
    {
        return view('dashboard.fields.create');
    }

    public function store(FieldStoreRequest $request)
    {
        Field::create($request->validated());
        return redirect()->route('dashboard.fields.index')
            ->with('message', trans('crud.success.store'))->with('class', 'alert-success');
    }

    public function show(Field $field)
    {
        return redirect()->route('dashboard.fields.edit', $field['id']);
    }

    public function edit(Field $field)
    {
        return view('dashboard.fields.edit')
            ->with('field', $field);
    }

    public function update(FieldUpdateRequest $request, Field $field)
    {
        $field->update($request->validated());
        return redirect()->route('dashboard.fields.index')
            ->with('message', trans('crud.success.update'))->with('class', 'alert-success');
    }

    public function destroy(Field $field)
    {
        $field->delete();
        return redirect()->route('dashboard.fields.index')
            ->with('message', trans('crud.success.delete'))->with('class', 'alert-success');
    }
}
