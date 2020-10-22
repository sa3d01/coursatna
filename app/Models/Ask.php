<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ask extends Model
{
    protected $fillable = [
        'section_id',
        'complexity',
        'question',
    ];
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    public function answer()
    {
        return $this->hasOne(Answer::class);
    }
}
