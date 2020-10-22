<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        if ($request->user()->token()->revoke()) {
            $request->user()->update([
                'fcm_token' => '',
            ]);
            return response()->json(['message' => "Logged out."], JsonResponse::HTTP_OK); // 200
        }
        return response()->json(null, JsonResponse::HTTP_UNAUTHORIZED); // 401
    }
}
