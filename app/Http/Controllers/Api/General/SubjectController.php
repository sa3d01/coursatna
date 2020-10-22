<?php

namespace App\Http\Controllers\Api\General;

use App\Http\Resources\General\SubjectDTO;
use App\Models\Subject;
use App\Http\Controllers\Controller;

class SubjectController extends Controller
{
    public function index()
    {
        return SubjectDTO::collection(Subject::paginate());
    }
}
