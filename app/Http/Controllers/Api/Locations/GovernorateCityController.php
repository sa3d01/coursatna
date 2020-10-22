<?php

namespace App\Http\Controllers\Api\Locations;

use App\Http\Controllers\Controller;
use App\Http\Resources\Locations\CityDTO;
use App\Models\City;
use App\Models\Governorate;

class GovernorateCityController extends Controller
{
    public function index(Governorate $governorate)
    {
        return response()->json(
            CityDTO::collection(City::where([
                'governorate_id' => $governorate->id,])->get()), 200
        );
    }
}
