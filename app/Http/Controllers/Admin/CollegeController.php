<?php

namespace App\Http\Controllers\Admin;

use App\Models\College;
use App\Models\Level;
use Illuminate\Http\Request;

class CollegeController extends MasterController
{
    public function __construct(College $model)
    {
        $this->model = $model;
        $this->route = 'college';
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
        return View('dashboard.create.create', [
            'type'=>'college',
            'action'=>'admin.college.store',
            'title'=>'أضافة كلية',
            'create_fields'=>['الاسم باللغة العربية' => 'name_ar','الاسم باللغة الانجليزية' => 'name_en'],
        ]);
    }
    public function show($id)
    {
        return View('dashboard.show.show', [
            'row' => $this->model->findOrFail($id),
            'type'=>'college',
            'action'=>'admin.college.update',
            'title'=>'بيانات الالكلية',
            'edit_fields'=>
                ['الاسم باللغة العربية' => 'name_ar','الاسم باللغة الانجليزية' => 'name_en']
            ,
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
        return View('dashboard.index.index', [
            'rows' => $rows,
            'type'=>'college',
            'title'=>'قائمة الكليات',
            'index_fields'=>['الاسم' => 'name_ar'],
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->validation_func(1),$this->validation_msg());
        $college=$this->model->create($request->all());
        $level=Level::where([
            'college_id'=>$college->id,
            'stage_id'=>3,
        ])->first();
        if (!$level){
            Level::create([
                'university_id'=>1,
                'college_id'=>$college->id,
                'stage_id'=>3,
                'class_stage_id'=>3
            ]);
        }
        return redirect()->route('admin.college.index')->with('created');
    }
    public function update($id,Request $request)
    {
        $this->validate($request, $this->validation_func(2),$this->validation_msg());
        $data=$request->all();
        $this->model->find($id)->update($data);
        return redirect('admin/' . $this->route . '')->with('updated', 'تم التعديل بنجاح');
    }


}
