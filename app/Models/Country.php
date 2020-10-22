<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'name_en',
        'name_ar',
    ];

    public function governorates()
    {
        return $this->hasMany(Governorate::class);
    }

}
