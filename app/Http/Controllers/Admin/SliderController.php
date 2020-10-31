<?php

namespace App\Http\Controllers\Admin;

use App\Models\Course;
use App\Models\Level;
use App\Models\Slider;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SliderController extends MasterController
{
    public function __construct(Slider $model)
    {
        $this->model = $model;
        $this->route = 'slider';
        parent::__construct();
    }

    public function validation_func($method, $id = null)
    {
        return [
            'link' => 'required',
            'image' => 'required',
            'levels' => 'required',
        ];
    }
    public function create()
    {
        return View('dashboard.create.create', [
            'type'=>'slider',
            'action'=>'admin.slider.store',
            'title'=>'أضافة سليدر',
            'create_fields'=>['العنوان' => 'title','الرابط'=>'link'],
            'multi_select'=>[
                'title'=>'المراحل التعليمية',
                'input_name'=>'levels',
                'rows'=>  Level::all()
            ],
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
        return View('dashboard.index.index', [
            'rows' => $rows,
            'type'=>'slider',
            'title'=>'قائمة الاسليدرز',
            'index_fields'=>['العنوان' => 'title','الرابط'=>'link'],
            'image'=>true,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->validation_func(1),$this->validation_msg());
        $data=$request->all();
        $levels=[];
        foreach ($request['levels'] as $level_id) {
            $levels[] = (int) $level_id;
        }
        $data['levels']= $levels;
        $this->model->create($data);
        return redirect()->route('admin.slider.index')->with('created');
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
