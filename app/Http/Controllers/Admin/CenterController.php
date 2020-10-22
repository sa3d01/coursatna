<?php

namespace App\Http\Controllers\Admin;

use App\Models\Center;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CenterController extends MasterController
{
    public function __construct(Center $model)
    {
        $this->model = $model;
        $this->route = 'center';
        parent::__construct();
    }

    public function validation_func($method, $id = null)
    {
        return [
            'name' => 'required',
            'mobile'=> 'required',
            'location'=> 'required',
        ];
    }
    public function create()
    {
        return View('dashboard.create.create', [
            'type'=>'center',
            'action'=>'admin.center.store',
            'title'=>'أضافة سنتر',
            'create_fields'=>['إسم السنتر' => 'name','رقم الهاتف'=>'mobile','العنوان'=>'location','تفاصيل أخري'=>'note'],
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
            'type'=>'center',
            'title'=>'قائمة السناتر',
            'index_fields'=>['إسم السنتر' => 'name','رقم الهاتف'=>'mobile',' المديونية'=>'debit'],
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->validation_func(1),$this->validation_msg());
        $this->model->create($request->all());
        return redirect()->route('admin.center.index')->with('created');
    }

    public function debit_decrement($id,Request $request){
        $center=$this->model->find($id);
        $debit_decrement_value=$request['debit_decrement_value'];
        if ($center->debit >= $debit_decrement_value) {
            $center->update(
                [
                    'debit' => $center->debit - $debit_decrement_value,
                ]
            );
        }
        $center->refresh();
        $center->refresh();
        return redirect()->back()->with('updated');
    }
}
