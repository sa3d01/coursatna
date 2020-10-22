<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'course_id',
        'course_session_id',
        'uploader_id',
        'name',
        'version',
        'type',
        'external_url',
        'file',
        'image',
        'description',
        'status',
    ];

    protected $appends = [
        'image_link',
        'file_link',
    ];

    public function setImageAttribute($image)
    {
        if (isset($this->attributes['image'])) {
            deleteFileFromServer($this->attributes['image']);
        }
        $this->attributes['image'] = uploadImage($image, 'items');
    }

    public function getImageLinkAttribute()
    {
        return getImageUrl($this->attributes['image']);
    }

    public function setFileAttribute($file)
    {
        if (isset($this->attributes['file'])) {
            deleteFileFromServer($this->attributes['file']);
        }
        $this->attributes['file'] = uploadFile($file, 'items');
    }

    public function getFileLinkAttribute()
    {
        return getFileUrl($this->attributes['file']);
    }

    public function getIsBoughtAttribute()
    {
        if (auth()->check()) {
            return $this->usersHaveBought->contains('id', auth()->id());
        }
        return false;
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
