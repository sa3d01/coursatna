<?php

namespace App\Http\Controllers\Api\Locations;

use App\Http\Controllers\Controller;
use App\Http\Resources\Locations\GovernorateDTO;
use App\Models\Governorate;

class GovernorateController extends Controller
{
    public function index()
    {
        return response()->json(GovernorateDTO::collection(Governorate::all()), 200);
    }
}
