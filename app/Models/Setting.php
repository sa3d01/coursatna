<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Setting extends Model
{
    protected $fillable = [
        'about_ar',
        'about_en',
        'terms_ar',
        'terms_en',
        'logo',
    ];
    protected function getLogoAttribute()
    {
        if ($this->attributes['logo'])
            return asset('media/images/logo/'). '/' . $this->attributes['logo'];
        return asset('media/images/logo/') . '/logo.png';
    }
    protected function setLogoAttribute()
    {
        $image=request('logo');
        if (is_file($image)){
            $filename = Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->move('media/images/logo/', $filename);
            $this->attributes['logo'] = $filename;
        }else{
            $this->attributes['logo'] = $image;
        }
    }
}
