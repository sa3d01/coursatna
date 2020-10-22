<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'attachment_id',

    ];
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function course(){
        return $this->belongsTo(Course::class,'course_id','id');
    }
    public function attachment(){
        return $this->belongsTo(Attachment::class,'attachment_id','id');
    }

}
