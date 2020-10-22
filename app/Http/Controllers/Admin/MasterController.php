<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Center;
use App\Models\Course;
use App\Models\User;
use BaconQrCode\Encoder\QrCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

abstract class MasterController extends Controller
{

    protected $model;
    protected $route;
    protected $module_name;
    protected $single_module_name;
    protected $index_fields;
    protected $show_fields;
    protected $create_fields;
    protected $update_fields;
    protected $json_fields;

    public function __construct()
    {
        $users_count=User::whereType('USER')->count();
        $courses_count=Course::count();
        $debits=Center::sum('debit');
        $this->middleware(['auth', 'permission:access-dashboard']);
        view()->share(array(
            'module_name' => $this->module_name,
            'single_module_name' => $this->single_module_name,
            'route' => $this->route,
            'index_fields' => $this->index_fields,
            'show_fields' => $this->show_fields,
            'create_fields' => $this->create_fields,
            'update_fields' => $this->update_fields,
            'json_fields' => $this->json_fields,
            'users_count'=>$users_count,
            'courses_count'=>$courses_count,
            'debits'=>$debits
        ));
    }
    public function destroy($id)
    {
        $this->model->find($id)->delete();
        return redirect()->back()->with('deleted', 'تم الحذف بنجاح');
    }
    public function update($id,Request $request)
    {
        $this->model->find($id)->update($request->except(['id']));
        return redirect('admin/' . $this->route . '')->with('updated', 'تم التعديل بنجاح');
    }
}

