<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\MoSmsMisr;
use App\Http\Requests\Api\PasswordForgotRequest;
use App\Http\Requests\Api\PasswordSetNewRequest;
use App\Http\Requests\Api\PasswordVerifyCodeRequest;
use App\Http\Resources\AuthUsers\SchoolStudent;
use App\Http\Resources\AuthUsers\UniversityStudent;
use App\Models\User;
use App\Models\PhoneVerificationCode;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    public function forgotPassword(PasswordForgotRequest $request)
    {
        $user = User::where(['phone' => $request['phone']])->first();
        if (!$user) {
            return response()->json(['message' => 'User Not Found'], 404);
        }

        $verificationCode = PhoneVerificationCode::create([
            'user_id' => $user->id,
            'token' => rand(11111, 99999),
            'phone' => $request->phone,
        ]);
//        $moSms = new MoSmsMisr([$user->phone]);
//        $moSms->send("Your verification code is '" . $verificationCode->code . "'");

        return response()->json(['message' => 'Verification message sent'], 200);
    }

    public function verifyCode(PasswordVerifyCodeRequest $request)
    {
        $user = User::where(['phone' => $request['phone']])->first();
        if (!$user) {
            return response()->json(['message' => 'User Not Found'], 404);
        }

        $verificationCode = PhoneVerificationCode::where([
            'token' => $request['verification_code'],
            'user_id' => $user->id,
            'phone' => $request->phone,
        ])->first();

        if (!$verificationCode) {
            return response()->json(['message' => 'Wrong verification code'], 400);
        }

        $tokenResult = $this->createToken('customer');
        $tokenResult->token->expires_at = Carbon::now()->addWeeks(1);
        return response()->json([
            "access_token" => [
                'token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
            ],
        ], 200);
    }

    public function setNewPassword(PasswordSetNewRequest $request)
    {
        $user = $request->user();
        $user->update(['password' => $request['new_password']]);
        return response()->json(new UniversityStudent($user), 202); //ACCEPTED
    }
}
