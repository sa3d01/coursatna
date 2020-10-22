<?php

namespace App\Traits\Api;

use App\Models\PhoneVerificationCode;
use Carbon\Carbon;

trait UserPhoneVerificationTrait
{
    protected function createPhoneVerificationCodeForUser($user)
    {
        $data = [
            'user_id' => $user->id,
            'phone' => $user->phone,
            'token' => 2021,//rand(1111, 9999),
            'expires_at' => Carbon::now()->addMinutes(10),
        ];
        PhoneVerificationCode::create($data);
        return $data;
    }

}
