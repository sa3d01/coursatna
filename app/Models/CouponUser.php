<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponUser extends Model
{
    protected $fillable = [
        'coupon_id',
        'coupon_pattern',
        'user_id',
        'teacher_id',
    ];
}
