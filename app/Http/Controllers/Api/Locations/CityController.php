<?php

namespace App\Http\Controllers\Api\Locations;

use App\Http\Controllers\Controller;
use App\Http\Resources\Locations\CityDTO;
use App\Models\City;

class CityController extends Controller
{
    public function index()
    {
        return response()->json(CityDTO::collection(City::all()), 200);
    }
}
