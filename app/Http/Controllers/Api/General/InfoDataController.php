<?php

namespace App\Http\Controllers\Api\General;

use App\Http\Controllers\Controller;
use App\Http\Resources\General\InfoDTO;
use App\Models\Setting;

class InfoDataController extends Controller
{
    public function info_data()
    {
        return response()->json(
            InfoDTO::make(Setting::first()),
            200
        );
    }

}
