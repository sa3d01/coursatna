<?php

namespace App\Http\Controllers\Admin;

use App\Models\Course;
use App\Models\Governorate;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GovernorateController extends MasterController
{
    public function __construct(Governorate $model)
    {
        $this->model = $model;
        $this->route = 'governorate';
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
            'type'=>'governorate',
            'action'=>'admin.governorate.store',
            'title'=>'أضافة محافظة',
            'create_fields'=>['الاسم باللغة العربية' => 'name_ar','الاسم باللغة الانجليزية' => 'name_en'],
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
            'type'=>'governorate',
            'title'=>'قائمة المحافظات',
            'index_fields'=>['الاسم' => 'name_ar'],
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->validation_func(1),$this->validation_msg());
        $this->model->create($request->all());
        return redirect()->route('admin.governorate.index')->with('created');
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
