<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Level;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LevelController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('type')) {
            return response()->json(Level::where('type', $request['type'])->get());
        }
        return response()->json(Level::all());
    }
}
