<?php

namespace App\Http\Controllers\Admin;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends MasterController
{
    public function __construct(Course $model)
    {
        $this->model = $model;
        $this->route = 'course';
        parent::__construct();
    }

    public function validation_func($method, $id = null)
    {
        return [
            'name' => 'required',
//            'teacher_id'=> 'required',
            'subject_id'=> 'required',
            'level_id'=> 'required',
            'image'=> 'required',
            'price'=> 'required',

        ];
    }
    public function create()
    {
        return View('dashboard.create.create', [
            'type'=>'course',
            'action'=>'admin.course.store',
            'title'=>'أضافة كورس',
            'create_fields'=>['إسم الكورس' => 'name','السعر' => 'price'],
            'image'=>true,
            'selects'=>[
//                [
//                    'input_name'=>'teacher_id',
//                    'rows'=>\App\Models\User::where('type','TEACHER')->get(),
//                    'title'=>'المدرس'
//                ],
                [
                    'input_name'=>'subject_id',
                    'rows'=>\App\Models\Subject::all(),
                    'title'=>'المادة'
                ],
                [
                    'input_name'=>'level_id',
                    'rows'=>\App\Models\Level::all(),
                    'title'=>'المرحلة'
                ],
            ],
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
            'type'=>'course',
            'title'=>'قائمة الكورسات',
            'index_fields'=>['الاسم' => 'name'],
            'image'=>true,
            'selects'=>[
//                [
//                    'name'=>'teacher',
//                    'title'=>'المدرس'
//                ],
                [
                    'name'=>'subject',
                    'title'=>'المادة'
                ],
                [
                    'name'=>'subject',
                    'title'=>'المرحلة'
                ],
            ],
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->validation_func(1),$this->validation_msg());
        $this->model->create($request->all());
        return redirect()->route('admin.course.index')->with('created');
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
