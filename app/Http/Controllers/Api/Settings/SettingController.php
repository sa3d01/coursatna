<?php

namespace App\Http\Controllers\Api\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Settings\LevelUpdateRequest;
use App\Http\Requests\Api\Settings\ProfileUpdateRequest;
use App\Http\Requests\Api\Settings\UploadAvatarRequest;
use App\Http\Resources\AuthUsers\StudentLoginDTO;
use App\Http\Resources\AuthUsers\StudentUserDTO;
use App\Models\Level;

class SettingController extends Controller
{
    public function uploadAvatar(UploadAvatarRequest $request)
    {
        return response()->json([
            "avatar" => FileService::upload($request->file('avatar'), $request->user(), "avatars", true)
        ], 200);
    }

    public function updateProfile(ProfileUpdateRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();
        $user->update($data);
        return response()->json(new StudentLoginDTO($user), 200);
    }

    public function updateLevel(LevelUpdateRequest $request)
    {
        $user = $request->user();
        $request->validated();
        $level_id=Level::where(['class_stage_id'=>$request['class_stage_id'],'stage_id'=>$request['stage_id']])->value('id');
        $data['level_id'] = $level_id;
        $user->update($data);

        return response()->json(new StudentUserDTO($user), 200);
    }

}
