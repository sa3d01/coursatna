<?php

namespace App\Traits;

use Storage;
use Auth;

trait UserTrait
{
    public function getProfileLinkAttribute()
    {
        return route('dashboard.users.edit', ['user' => $this['id']]);
    }

    public function setAvatarAttribute($avatar)
    {
        if (isset($this->attributes['avatar'])) {
            deleteFileFromServer($this->attributes['avatar']);
        }
        $this->attributes['avatar'] = uploadImage($avatar, 'avatars');
    }

    public function getAvatarLinkAttribute()
    {
        /*if (isset($this->attributes['avatar'])) {
            return getImageUrl($this->attributes['avatar']);
        }*/
        if (isset($this->attributes['avatar'])) {
            return getImageUrl($this->attributes['avatar']);
        }
        return asset('assets/dashboard/img/avatar/avatar-1.png');
    }
//    public function getAvatarLinkAttribute()
//    {
//        if (Storage::disk('public')->exists($this->avatar)) {
//            return Storage::disk('public')->url($this->avatar);
//        }
//        return asset('assets/dashboard/img/avatar/avatar-1.png');
//    }

    public function setCoverPhotoAttribute($coverPhoto)
    {
        if (isset($this->attributes['cover_photo'])) {
            deleteFileFromServer($this->attributes['cover_photo']);
        }
        $this->attributes['cover_photo'] = uploadImage($coverPhoto, 'cover_photos');
    }

    public function getCoverPhotoLinkAttribute()
    {
        if (isset($this->attributes['cover_photo'])) {
            return getImageUrl($this->attributes['cover_photo']);
        }
        return asset('assets/dashboard/img/cover_photo/avatar-1.png');
    }

    public function getIsMeAttribute()
    {
        if (Auth::check() && Auth::id() == $this['id']) {
            return true;
        }
        return false;
    }
}
