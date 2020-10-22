<?php

namespace App\Http\Controllers\Api\General;

use App\Http\Resources\Course\CourseDTO;
use App\Http\Resources\General\ClassStageDTO;
use App\Http\Resources\General\LevelDTO;
use App\Http\Resources\General\SliderDTO;
use App\Http\Resources\General\StageDTO;
use App\Models\ClassStage;
use App\Models\Level;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\Stage;

class SliderController extends Controller
{
    public function index()
    {
        $sliders=Slider::whereJsonContains('levels', request()->user()->level_id)->get();
        
        return response()->json(
            SliderDTO::collection(Slider::all()),
            200
        );
    }
}
