<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Course;
use App\Models\Governorate;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CityController extends MasterController
{
    public function __construct(City $model)
    {
        $this->model = $model;
        $this->route = 'city';
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
            'type'=>'city',
            'action'=>'admin.city.store',
            'title'=>'أضافة مدينة',
            'create_fields'=>['الاسم باللغة العربية' => 'name_ar','الاسم باللغة الانجليزية' => 'name_en'],
            'selects'=>[
                [
                    'input_name'=>'governorate_id',
                    'rows'=>\App\Models\Governorate::all(),
                    'title'=>'المحافظة'
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
            'type'=>'city',
            'title'=>'قائمة المدن',
            'index_fields'=>['الاسم' => 'name_ar'],
            'selects'=>[
                [
                    'name'=>'governorate',
                    'title'=>'المحافظة'
                ],
            ],
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->validation_func(1),$this->validation_msg());
        $this->model->create($request->all());
        return redirect()->route('admin.city.index')->with('created');
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
