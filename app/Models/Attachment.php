<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Attachment extends Model
{
    protected $fillable = [
        'course_id',
        'uploader_id',
        'name',
        'file_type',
        'external_url',
        'file',
        'image',
        'price',
        'status',
    ];

    protected $appends = [
        'image_link',
        'file_link',
    ];

    private $route='course';
    private $images_link='media/images/course/';

    public function setFileAttribute($file)
    {
        if (isset($this->attributes['file'])) {
            deleteFileFromServer($this->attributes['file']);
        }
        $this->attributes['file'] = $this->upload_file($file);
    }

    public function getFileAttribute()
    {
        $dest='media/files/course/';
        try {
            if ($this->attributes['file'])
                return asset($dest). '/' . $this->attributes['file'];
            return asset($dest) . '/default.png';
        }catch (\Exception $e){
            return asset($dest) . '/default.png';
        }
    }

    public function getIsBoughtAttribute()
    {
        if (auth()->check()) {
            return $this->usersHaveBought->contains('id', auth()->id());
        }
        return false;
    }

    private function upload_file($file){
        $filename = Str::random(10) . '.' . $file->getClientOriginalExtension();
        $file->move('media/files/course/', $filename);
        return $filename;
    }
    protected function setImageAttribute()
    {
        $image=request('image');
        $filename=null;
        if (is_file($image)) {
            $filename = Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->move('media/images/course/', $filename);
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
    ///////////////////////////////////////////////////////

//    public function usersHaveBought()
//    {
//        return $this->belongsToMany(User::class, 'user_bought_item', 'item_id', 'buyer_id');
//    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function courseSession()
    {
        return $this->belongsTo(CourseSession::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploader_id');
    }

//    public function buyers()
//    {
//        return $this->belongsToMany(User::class, 'user_bought_item', 'item_id', 'buyer_id');
//    }
}
