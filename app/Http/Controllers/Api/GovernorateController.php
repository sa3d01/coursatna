<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\GovernoratesCollection;
use App\Models\Governorate;
use App\Http\Controllers\Controller;

class GovernorateController extends Controller
{
    public function index($countryId)
    {
        return response()->json(
            new GovernoratesCollection(Governorate::where([
                'country_id' => $countryId,
            ])->get()),
            200
        );
    }
}
