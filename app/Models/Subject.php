<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Subject extends Model
{
    protected $fillable = [
        'name_en',
        'name_ar',
        'image',
    ];
    private $images_link='media/images/subject/';

    public function nameForSelect(){
        return $this->name_ar;
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
            return asset('media/images/course/') . '/default.png';
        }catch (\Exception $e){
            return asset('media/images/course/') . '/default.png';
        }
    }
}
