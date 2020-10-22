<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $fillable = [
        'class_stage_id',
        'stage_id',
        'subjects',
        'status',
    ];
    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }
    public function class_stage()
    {
        return $this->belongsTo(ClassStage::class);
    }
    protected $casts = [
        'subjects' => 'array',
    ];
    public function nameForSelect(){
        return $this->class_stage->name_ar.'-'.$this->stage->name_ar;
    }
}
