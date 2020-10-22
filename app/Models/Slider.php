<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Slider extends Model
{
    protected $fillable = [
        'class',
        'title',
        'image',
        'link',
        'levels',
        'status',
    ];
    protected $casts = [
        'levels' => 'array',
    ];
    private $images_link='media/images/slider/';

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
