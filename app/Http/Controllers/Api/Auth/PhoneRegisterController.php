<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\MoSmsMisr;
use App\Http\Enums\UserRoles;
use App\Http\Requests\Api\PhoneRegisterRequest;
use App\Models\Level;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\PhoneVerificationCode;
use App\Traits\Api\LoginTrait;
use App\Traits\Api\UserPhoneVerificationTrait;
use Spatie\Permission\Models\Role;

class PhoneRegisterController extends Controller
{
    use LoginTrait;
    use UserPhoneVerificationTrait;

    public function register(PhoneRegisterRequest $request)
    {
        $data = $request->validated();
        $data['banned'] = false;
        $data['locale'] = "en";
        $data['notification_toggle'] = true;
        $data['last_ip'] = $request->ip();
        if ($request['stage_id'] && $request['class_stage_id']){
            $level_id=Level::where(['class_stage_id'=>$request['class_stage_id'],'stage_id'=>$request['stage_id']])->value('id');
            $data['level_id'] = $level_id;
        }
        $user = User::create($data);
        $role = Role::findOrCreate(UserRoles::ROLE_USER);
        $user->assignRole($role);

        //$this->sendVerificationSms($user);
        $verificationData = $this->createPhoneVerificationCodeForUser($user);
        //return response()->json(['message' => 'Verification code sent'], 200);
        return response()->json([
            "phone" => $request["phone"],
            "token" => $verificationData['token'], //TODO: remove at production
            "note_ya_Jemmy" => 'the field "token" return only in development mode ya So7ab Jemmy so you can test easily'
        ], 200);
    }

    private function sendVerificationSms(User $user)
    {
        $verificationCode = PhoneVerificationCode::create([
            'user_id' => $user->id,
            'token' => rand(11111, 99999),
        ]);

        $moSms = new MoSmsMisr([$user->phone]);
        $moSms->send("Your GCourses verification code is " . $verificationCode->code);
    }

}

