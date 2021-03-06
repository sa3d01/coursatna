<?php

namespace App\Http\Controllers\Admin;

use App\Models\Course;
use App\Models\CourseSession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseSessionController extends MasterController
{
    public function __construct(CourseSession $model)
    {
        $this->model = $model;
        $this->route = 'course_session';
        parent::__construct();
    }

    public function validation_func($method, $id = null)
    {
        return [
            'topic' => 'required',
            'file'=>'required',

        ];
    }
     public function validation_msg()
    {
        return array(
            'required' => 'يجب ملئ جميع الحقول',
        );
    }
    public function index()
    {
        if(\Auth::user()->getRoleArabicName()=='TEACHER'){
            $teacher=User::find(\Auth::user()->id);
            $course_ids=Course::where('teacher_id',$teacher->id)->pluck('id');
            $rows=$this->model->whereIn('course_id',$course_ids)->latest()->get();
        }else{
            $rows = $this->model->latest()->get();
        }
        return View('dashboard.index.index', [
            'rows' => $rows,
            'type'=>'course_session',
            'title'=>'قائمة الحصص',
            'index_fields'=>['الاسم' => 'topic'],
            'selects'=>[
                [
                    'name'=>'course',
                    'title'=>'الكورس'
                ],
            ],
        ]);
    }
    public function create()
    {
        if(\Auth::user()->getRoleArabicName()=='TEACHER'){
            $teacher=User::find(\Auth::user()->id);
            $courses=Course::where('teacher_id',$teacher->id)->get();
            return View('dashboard.create.create', [
                'type'=>'course',
                'action'=>'admin.course_session.store',
                'title'=>'أضافة حصة',
                'create_fields'=>['عنوان الحصة' => 'topic','تاريخ البدأ' => 'start_date','تاريخ التوقف' => 'end_date'],
                'selects'=>[
                    [
                        'input_name'=>'course_id',
                        'rows'=>$courses,
                        'title'=>'الكورس',
                    ],
                ],
                'video'=>true
            ]);
        }else{
            return View('dashboard.create.create', [
                'type'=>'course',
                'action'=>'admin.course_session.store',
                'title'=>'أضافة حصة',
                'create_fields'=>['عنوان الحصة' => 'topic','تاريخ البدأ' => 'start_date','تاريخ التوقف' => 'end_date'],
                'selects'=>[
                    [
                        'input_name'=>'course_id',
                        'rows'=>\App\Models\Course::all(),
                        'title'=>'الكورس',
                    ],
                ],
                'video'=>true
            ]);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->validation_func(1),$this->validation_msg());
        $data=$request->all();
        $data['file_type']=$request['file']->getClientOriginalExtension();
        $this->model->create($data);
        return redirect()->route('admin.course_session.index')->with('created');
    }


}
