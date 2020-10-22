<?php

namespace App\Http\Controllers\Admin;

use App\Models\Course;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends MasterController
{
    public function __construct(Subject $model)
    {
        $this->model = $model;
        $this->route = 'subject';
        parent::__construct();
    }

    public function validation_func($method, $id = null)
    {
        return [
            'name_ar' => 'required',
            'name_en' => 'required',
        ];
    }
    public function create()
    {
        return View('dashboard.subject.create', [
            'type'=>'subject',
            'action'=>'admin.subject.store',
            'title'=>'أضافة مادة دراسية',
            'create_fields'=>['الاسم باللغة العربية' => 'name_ar','الاسم باللغة الانجليزية' => 'name_en'],
            'image'=>true,
        ]);
    }
    public function show($id)
    {
        return View('dashboard.subject.show', [
            'row' => $this->model->findOrFail($id),
            'type'=>'subject',
            'action'=>'admin.subject.update',
            'title'=>'بيانات المادة الدراسية',
            'edit_fields'=>
                ['الاسم باللغة العربية' => 'name_ar','الاسم باللغة الانجليزية' => 'name_en']
            ,
            'image'=>true,
        ]);
    }
    public function validation_msg()
    {
        return array(
            'required' => 'يجب ملئ جميع الحقول',
        );
    }

    public function index()
    {
        $rows = $this->model->latest()->get();
        return View('dashboard.subject.index', [
            'rows' => $rows,
            'type'=>'subject',
            'title'=>'قائمة المواد الدراسية',
            'index_fields'=>['الاسم' => 'name_ar'],
            'image'=>true,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->validation_func(1),$this->validation_msg());
        $this->model->create($request->all());
        return redirect()->route('admin.subject.index')->with('created');
    }
    public function update($id,Request $request)
    {
        $this->validate($request, $this->validation_func(2),$this->validation_msg());
        $data=$request->all();
        $this->model->find($id)->update($data);
        return redirect('admin/' . $this->route . '')->with('updated', 'تم التعديل بنجاح');
    }


}
