<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $fillable = [
        'class_stage_id',
        'stage_id',
        'subjects',
        'university_id',
        'college_id',
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
    public function college()
    {
        return $this->belongsTo(College::class);
    }
    public function university()
    {
        return $this->belongsTo(University::class);
    }
    protected $casts = [
        'subjects' => 'array',
    ];
    public function nameForSelect(){
        if ($this->university_id!=null){
            return $this->university->name_ar.'-'.$this->college->name_ar.'-'.$this->class_stage->name_ar;
        }
        return $this->class_stage->name_ar.'-'.$this->stage->name_ar;
    }
}
