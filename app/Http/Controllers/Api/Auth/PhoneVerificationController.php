<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\MoSmsMisr;
use App\Http\Requests\Api\PhoneResendCodeRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PhoneVerifyRequest;
use App\Http\Resources\AuthUsers\StudentLoginDTO;
use App\Models\User;
use App\Models\PhoneVerificationCode;
use Carbon\Carbon;

class PhoneVerificationController extends Controller
{
    public function resendCode(PhoneResendCodeRequest $request)
    {
        $user = User::where(['phone' => $request['phone']])->first();
        if (!$user) {
            return response()->json(['message' => 'User Not Found'], 404);
        }
        if ($user->phone_verified_at) {
            return response()->json(['message' => 'User Phone already verified'], 400);
        }

        $verificationCode = PhoneVerificationCode::where([
            'user_id' => $user->id,
        ])->first();
        if (!$verificationCode) {
            $verificationCode = PhoneVerificationCode::create([
                'user_id' => $user->id,
                'token' => rand(11111, 99999),
            ]);
        }

//        $moSms = new MoSmsMisr([$user->phone]);
//        $moSms->send("Your GCourses verification code is " . $verificationCode->code);

        return response()->json(['message' => 'Verification code sent'], 200);
    }

    public function verifyUser(PhoneVerifyRequest $request)
    {
        $user = User::where(['phone' => $request['phone']])->first();
        if (!$user) {
            return response()->json(['message' => 'User Not Found'], 404);
        }
        if ($user->phone_verified_at) {
            return response()->json(['message' => 'User Phone already verified'], 400);
        }

        $verificationCode = PhoneVerificationCode::where([
            'token' => $request['verification_code'],
            'user_id' => $user->id,
        ])->first();

        if (!$verificationCode) {
            return response()->json(['message' => 'Wrong verification code'], 400);
        }

        $user->update(['phone_verified_at' => Carbon::now()]);
        return response()->json(new StudentLoginDTO($user), 200);
    }
}
