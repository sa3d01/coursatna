<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    protected $fillable = [
        'name',
        'mobile',
        'location',
        'note',
        'debit',
    ];
    public function teachers(){
        return $this->hasMany(User::class,'center_id','id');
    }
    public function nameForSelect(){
        return $this->name;
    }
    public function debitDecrement()
    {
        $action = route('admin.center.debit_decrement', ['id' => $this->attributes['id']]);
        return "<a style='color: #0a0b0b' class='debit_decrement btn btn-warning btn-sm' data-href='$action' href='$action'><i class='os-icon os-icon-check-circle'></i><span>تسديد</span></a>";
    }
}
