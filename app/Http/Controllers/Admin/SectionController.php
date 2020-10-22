<?php

namespace App\Http\Controllers\Admin;

use App\Models\ClassStage;
use App\Models\Level;
use App\Models\Section;
use App\Models\Stage;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends MasterController
{
    public function __construct(Section $model)
    {
        $this->model = $model;
        $this->route = 'section';
        parent::__construct();
    }

    public function validation_func($method, $id = null)
    {
        return [
            'name_ar' => 'required',
            'name_en' => 'required',
            'level_id' => 'required',
            'subject_id' => 'required',
        ];
    }

    public function validation_msg()
    {
        return array(
            'required' => 'يجب ملئ جميع الحقول',
        );
    }
    function auth_sections(){
        $permissions=Auth::user()->getAllPermissionsAttribute();
        $class_stage_ids=[];
        $stage_ids=[];
        $subject_ids=[];
        foreach ($permissions as $permission) {
            if ($permission == $permissions[0])
                continue;
            $data=explode('-',$permission);
            $class_stage_ids[]= ClassStage::where('name_ar',$data[2])->value('id');
            $stage_ids[]= Stage::where('name_ar',$data[3])->value('id');
            $subject_ids[]=Subject::where('name_ar',$data[4])->value('id');
        }
        $level_ids=Level::whereIn('class_stage_id',$class_stage_ids)->whereIn('stage_id',$stage_ids)->pluck('id');
        return Section::whereIn('level_id',$level_ids)->whereIn('subject_id',$subject_ids)->latest()->get();
    }
    function auth_levels(){
        $permissions=Auth::user()->getAllPermissionsAttribute();
        $class_stage_ids=[];
        $stage_ids=[];
        foreach ($permissions as $permission) {
            if ($permission == $permissions[0])
                continue;
            $data=explode('-',$permission);
            $class_stage_ids[]= ClassStage::where('name_ar',$data[2])->value('id');
            $stage_ids[]= Stage::where('name_ar',$data[3])->value('id');
        }
        return Level::whereIn('class_stage_id',$class_stage_ids)->whereIn('stage_id',$stage_ids)->get();
    }
    function auth_subjects(){
        $permissions=Auth::user()->getAllPermissionsAttribute();
        $subject_ids=[];
        foreach ($permissions as $permission) {
            if ($permission == $permissions[0])
                continue;
            $data=explode('-',$permission);
            $subject_ids[]=Subject::where('name_ar',$data[4])->value('id');
        }
        return Subject::whereIn('id',$subject_ids)->get();
    }

    public function index()
    {
        $rows = $this->auth_sections();
        return View('dashboard.section.index', [
            'rows' => $rows,
            'type'=>'section',
            'title'=>'قائمة الأبواب الدراسية',
            'index_fields'=>['الاسم' => 'name_ar'],
            'selects'=>[
                [
                    'name'=>'subject',
                    'title'=>'المادة'
                ],
                [
                    'name'=>'level',
                    'title'=>'المرحلة'
                ],
            ]
        ]);
    }
    public function create()
    {
        return View('dashboard.section.create', [
            'type'=>'section',
            'action'=>'admin.section.store',
            'title'=>'أضافة باب دراسي',
            'create_fields'=>['الاسم باللغة العربية' => 'name_ar','الاسم باللغة الانجليزية' => 'name_en'],
            'selects'=>[
                [
                    'input_name'=>'level_id',
                    'rows'=>$this->auth_levels(),
                    'title'=>'المستوى الدراسي'
                ],
                [
                    'input_name'=>'subject_id',
                    'rows'=>$this->auth_subjects(),
                    'title'=>'المادة الرداسية'
                ],
            ],
        ]);
    }
    public function store(Request $request)
    {
        $this->validate($request, $this->validation_func(1),$this->validation_msg());
        $this->model->create($request->all());
        return redirect()->route('admin.section.index')->with('created');
    }
    public function update($id,Request $request)
    {
        $this->validate($request, $this->validation_func(2),$this->validation_msg());
        $data=$request->all();
        $name['ar']=$request['name_ar'];
        $data['name']=$name;
        $this->model->find($id)->update($data);
        return redirect('admin/' . $this->route . '')->with('updated', 'تم التعديل بنجاح');
    }


}
