<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Course extends Model
{
    protected $fillable = [
        'name',
        'teacher_id',
        'subject_id',
        'level_id',
        'image',
        'price',
        'status',
    ];
    private $route='course';
    private $images_link='media/images/course/';

    public function teacher()
    {
        return $this->belongsTo(User::class, "teacher_id");
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    public function level()
    {
        return $this->belongsTo(Level::class);
    }
    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
    public function sessions()
    {
        return $this->hasMany(CourseSession::class);
    }

    // rate
    public function ratings(){
        return $this->hasMany(Rating::class);
    }

    private function upload_file($file){
        $filename = Str::random(10) . '.' . $file->getClientOriginalExtension();
        $file->move($this->images_link, $filename);
        return $filename;
    }
    protected function setImageAttribute()
 {
        $image=request('image');
        $filename=null;
        if (is_file($image)) {
            $filename = $this->upload_file($image);
        }elseif (filter_var($image, FILTER_VALIDATE_URL) === True) {
            $filename = $image;
        }
        $this->attributes['image'] = $filename;
    }

    protected function getImageAttribute()
    {
        $dest=$this->images_link;
        try {
            if ($this->attributes['image'])
                return asset($dest). '/' . $this->attributes['image'];
            return asset($dest) . '/default.png';
        }catch (\Exception $e){
            return asset($dest) . '/default.png';
        }
    }
    public function nameForSelect(){
        return $this->name;
    }
}
