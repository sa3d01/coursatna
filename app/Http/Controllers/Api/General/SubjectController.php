<?php

namespace App\Http\Controllers\Api\General;

use App\Http\Resources\General\SubjectDTO;
use App\Models\Level;
use App\Models\Subject;
use App\Http\Controllers\Controller;

class SubjectController extends Controller
{
    public function index()
    {
        if (request()->user()){
            $subject_ids=Level::whereId(request()->user()->level_id)->value('subjects');
            $subjects=Subject::whereIn('id',$subject_ids)->latest()->paginate();
            return SubjectDTO::collection($subjects);
        }
        return SubjectDTO::collection(Subject::paginate());
    }
}
