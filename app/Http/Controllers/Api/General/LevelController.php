<?php

namespace App\Http\Controllers\Api\General;

use App\Http\Resources\Course\CourseDTO;
use App\Http\Resources\General\ClassStageDTO;
use App\Http\Resources\General\LevelDTO;
use App\Http\Resources\General\StageDTO;
use App\Models\ClassStage;
use App\Models\College;
use App\Models\Level;
use App\Http\Controllers\Controller;
use App\Models\Stage;
use App\Models\University;

class LevelController extends Controller
{
    public function index()
    {
        return response()->json(
            LevelDTO::collection(Level::all()),
            200
        );
    }

    public function stages()
    {
        $classes=Stage::all();
        if (request()->learn_type=='College'){
            $classes=Stage::whereIn('id',[3])->get();
        }elseif (request()->learn_type=='School'){
            $classes=Stage::whereIn('id',[1,2])->get();
        }
        return response()->json(
            StageDTO::collection($classes),
            200
        );
    }
    public function class_stages()
    {
        $classes=ClassStage::whereIn('id',[1,2,3])->get();
        if (request()->learn_type=='College'){
//            $classes=ClassStage::all();
            return response()->json(
                ClassStageDTO::collection(College::all()),
                200
            );
        }
        return response()->json(
            ClassStageDTO::collection($classes),
            200
        );
    }
    public function colleges()
    {
        return response()->json(
            StageDTO::collection(College::all()),
            200
        );
    }
    public function universities()
    {
        return response()->json(
            StageDTO::collection(University::all()),
            200
        );
    }
}
