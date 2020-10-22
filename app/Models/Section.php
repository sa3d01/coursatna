<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = [
        'name_ar',
        'name_en',
        'level_id',
        'subject_id',
    ];
    public function level()
    {
        return $this->belongsTo(Level::class);
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    public function nameForSelect(){
        return $this->name_ar;
    }
}
