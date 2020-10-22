<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\Api\LoginRequest;
use App\Models\User;
use App\Traits\Api\LoginTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PhoneLoginController extends Controller
{
    use LoginTrait;

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('phone', 'password');
        $user = User::where(['phone' => $request['phone']])->first();
        if (!$user) {
            return response()->json(['message' => 'User Not Fount'], 404);
        }
//        if (!$user->phone_verified_at) {
//            return response()->json(['message' => 'User phone did not verified'], 400);
//        }

        if (auth()->attempt($credentials)) {
            return $this->loginUser($user, $request);
        }
        return response()->json(['message' => "Wrong credentials."], 401); // HTTP_UNAUTHORIZED
    }
}
