<?php

namespace App\Http\Controllers\Admin;

use App\Models\Answer;
use App\Models\Ask;
use App\Models\ClassStage;
use App\Models\Course;
use App\Models\Section;
use App\Models\Stage;
use App\Models\Subject;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AskController extends MasterController
{
    public function __construct(Ask $model)
    {
        $this->model = $model;
        $this->route = 'ask';
        parent::__construct();
    }

    public function validation_func($method, $id = null)
    {
        return [
            'question' => 'required',
            'section_id' => 'required',
            'complexity' => 'required',
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
    function auth_asks(){
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
        $section_ids= Section::whereIn('level_id',$level_ids)->whereIn('subject_id',$subject_ids)->latest()->pluck('id');
        return Ask::whereIn('section_id',$section_ids)->latest()->get();
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
    public function create()
    {
        return View('dashboard.ask.create', [
            'type'=>'ask',
            'action'=>'admin.ask.store',
            'title'=>'أضافة سؤال',
            'create_fields'=>['نص السؤال' => 'question','نص الإجابة الصحيحة' => 'answer','مستوى الصعوبة'=>'complexity'],
            'selects'=>[
                [
                    'input_name'=>'section_id',
                    'rows'=>$this->auth_sections(),
                    'title'=>'الباب الدراسي'
                ]
            ],
        ]);
    }
    public function index()
    {
        $rows=$this->auth_asks();
        return View('dashboard.ask.index', [
            'rows' => $rows,
            'type'=>'ask',
            'title'=>'قائمة الأسئلة',
            'index_fields'=>['نص السؤال' => 'question','مستوى الصعوبة'=>'complexity'],
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->validation_func(1),$this->validation_msg());
        $ask=$this->model->create($request->all());
        Answer::create([
           'section_id'=>$request['section_id'],
            'ask_id'=>$ask->id,
            'answer'=>$request['answer'],
            'true_answer'=>1
        ]);
        foreach ($request['answers'] as $wrong_answer){
            Answer::create([
                'section_id'=>$request['section_id'],
                'ask_id'=>$ask->id,
                'answer'=>$wrong_answer
            ]);
        }
        return redirect()->route('admin.ask.index')->with('created');
    }
}
