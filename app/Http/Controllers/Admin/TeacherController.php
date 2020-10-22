<?php

namespace App\Http\Controllers\Admin;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends MasterController
{
    public function __construct(User $model)
    {
        $this->model = $model;
        $this->route = 'teacher';
        parent::__construct();
    }

    public function validation_func($method, $id = null)
    {
        if ($method == 1)
            return [
                'name' => 'required',
                'center_id' => 'required',
                'subject_id' => 'required',
                'phone' => 'required|max:13|unique:users',
                'email' => 'email|max:255|unique:users',
                'password' => 'required|min:6'
            ];
        return [
            'name' => 'required',
            'center_id' => 'required',
            'subject_id' => 'required',
            'phone' => 'required|max:13|unique:users,phone,' . $id,
            'email' => 'email|max:255|unique:users,email,' . $id,
        ];
    }

    public function validation_msg()
    {
        return array(
            'required' => 'يجب ملئ جميع الحقول',
            'email.unique' => 'هذا البريد مسجل من مقبل',
            'password.min' => 'يجب الا تقل كلمة المرور عن 6 عناصر',
            'phone.unique' => 'هذا الجوال مسجل من مقبل',
        );
    }

    public function index()
    {
        $rows = $this->model->whereType('TEACHER')->get();
        return View('dashboard.index.index', [
            'rows' => $rows,
            'type'=>'teacher',
            'title'=>'قائمة المدرسين',
            'index_fields'=>['الاسم' => 'name'],
            'selects'=>[
                [
                    'name'=>'center',
                    'title'=>'السنتر'
                ],
                [
                    'name'=>'subject',
                    'title'=>'المادة'
                ],
            ]
        ]);
    }
    public function create()
    {
        return View('dashboard.create.create', [
            'type'=>'teacher',
            'action'=>'admin.teacher.store',
            'title'=>'أضافة مدرس',
            'create_fields'=>['الاسم' => 'name', 'البريد الإلكترونى' => 'email', 'الجوال' => 'phone'],
            'password'=>true,
            'selects'=>[
                [
                    'input_name'=>'center_id',
                    'rows'=>\App\Models\Center::all(),
                    'title'=>'السنتر'
                ],
                [
                    'input_name'=>'subject_id',
                    'rows'=>\App\Models\Subject::all(),
                    'title'=>'المادة'
                ],
            ],
        ]);
    }
    public function store(Request $request)
    {
        $this->validate($request, $this->validation_func(1),$this->validation_msg());
        $data=$request->all();
        $data['type']='TEACHER';
        $data['email_verified_at']=now();
        $data['phone_verified_at']=now();
        $this->model->create($data);
        return redirect()->route('admin.teacher.index')->with('created');
    }
}
