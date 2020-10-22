<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassStage extends Model
{
    protected $fillable = [
        'name_ar',
        'name_en',
        'status',
    ];
}
