<?php

namespace App\Http\Controllers\Dashboard;

use App\Traits\MoneyOperations\ChargingCodesFileTrait;
use App\Http\Controllers\Controller;

class ChargingCodesFileController extends Controller
{
    use ChargingCodesFileTrait;
}
