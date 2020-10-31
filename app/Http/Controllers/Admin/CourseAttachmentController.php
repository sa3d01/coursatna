<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attachment;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseAttachmentController extends MasterController
{
    public function __construct(Attachment $model)
    {
        $this->model = $model;
        $this->route = 'course_attachment';
        parent::__construct();
    }

    public function validation_func($method, $id = null)
    {
        return [
            'name' => 'required',
            'price'=> 'required',
            'file'=> 'required',
        ];
    }
    public function create()
    {
        if(\Auth::user()->getRoleArabicName()=='TEACHER'){
            $teacher=User::find(\Auth::user()->id);
            $courses=Course::where('teacher_id',$teacher->id)->get();
            return View('dashboard.create.create', [
                'type'=>'course_attachment',
                'action'=>'admin.course_attachment.store',
                'title'=>'أضافة ملف',
                'create_fields'=>['إسم الملف' => 'name','السعر' => 'price'],
                'pdf'=>true,
                'image'=>true,
                'selects'=>[
                    [
                        'input_name'=>'course_id',
                        'rows'=>$courses,
                        'title'=>'الكورس'
                    ],

                ],
            ]);
        }else{
            return View('dashboard.create.create', [
                'type'=>'course_attachment',
                'action'=>'admin.course_attachment.store',
                'title'=>'أضافة ملف',
                'create_fields'=>['إسم الملف' => 'name','السعر' => 'price'],
                'pdf'=>true,
                'image'=>true,
                'selects'=>[
                    [
                        'input_name'=>'course_id',
                        'rows'=>Course::all(),
                        'title'=>'الكورس'
                    ],
                ],
            ]);
        }
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
            'type'=>'course_attachment',
            'title'=>'قائمة الملزمات',
            'index_fields'=>['إسم الملف' => 'name','السعر' => 'price'],
            'image'=>true,
            'selects'=>[
                [
                    'name'=>'course',
                    'title'=>'الكورس'
                ],
            ],
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->validation_func(1),$this->validation_msg());
        $data=$request->all();
        $data['file_type']='pdf';
        $this->model->create($data);
        return redirect()->route('admin.course_attachment.index')->with('created');
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

    // public function show($id)
    // {
    //     $row = $this->model->findOrFail($id);
    //     return View('dashboard.show.show', [
    //         'row' => $row,
    //         'type'=>'category',
    //         'action'=>'admin.category.update',
    //         'title'=>'قسم',
    //         'edit_fields'=>['الإسم' => 'name'],
    //         'languages'=>true,
    //         'image'=>true,
    //         'status'=>true,

    //     ]);
    // }

}
