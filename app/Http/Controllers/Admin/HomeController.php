<?php

namespace App\Http\Controllers\Admin;


use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends MasterController
{
    public function __construct()
    {
        // $this->middleware('permission:view-settings', ['only' => ['setting']]);
        // $this->middleware('permission:edit-settings', ['only' => ['update_setting']]);
        parent::__construct();
    }

    public function index(){
//        return \QrCode::size(250)->generate('ItSolutionStuff.com');
        return view('dashboard.index');
    }
    public function setting(){
        $row = Setting::first();
        return View('dashboard.settings', [
            'row' => $row,
        ]);
    }
    public function update_setting(Request $request){
        $data=$request->all();
        Setting::updateOrCreate(['id'=>1],$data);
        return redirect()->back()->with('updated', 'تم التعديل بنجاح');
    }

}
