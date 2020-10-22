<?php

namespace App\Http\Controllers\Api\General;

use App\Http\Resources\Course\CourseDTO;
use App\Http\Resources\General\ClassStageDTO;
use App\Http\Resources\General\LevelDTO;
use App\Http\Resources\General\StageDTO;
use App\Models\ClassStage;
use App\Models\Level;
use App\Http\Controllers\Controller;
use App\Models\Stage;

class LevelController extends Controller
{
    public function index()
    {
        return response()->json(
            LevelDTO::collection(Level::all()),
            200
        );
    }
    public function class_stages()
    {
        return response()->json(
            ClassStageDTO::collection(ClassStage::all()),
            200
        );
    }
    public function stages()
    {
        return response()->json(
            StageDTO::collection(Stage::all()),
            200
        );
    }
}
