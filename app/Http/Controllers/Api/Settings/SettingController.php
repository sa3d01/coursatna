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
        $level_data=[
            'class_stage_id'=>$request['class_stage_id'],
            'stage_id'=>$request['stage_id'],
        ];
        //التصنيف هيكون الكلية فى A-Z والخره ده مش انا وربنا السبب فيه :\
        if ($user->learn_type=='College'){
            $level_data=[
                'college_id'=>$request['class_stage_id'],
                'stage_id'=>$request['stage_id'],
            ];
        }
        $level=Level::where($level_data)->first();
        if (!$level){
            $level=Level::create($level_data);
        }
        $data['level_id'] = $level->id;
        if ($request['stage_id']==3){
            $data['learn_type']='College';
        }else{
            $data['learn_type']='School';
        }
        $user->update($data);
        return response()->json(new StudentUserDTO($user), 200);
    }

}
