<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
        'section_id',
        'ask_id',
        'answer',
        'true_answer',
    ];
    public function nameForSelect(){
        return $this->answer;
    }
}
