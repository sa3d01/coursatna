<?php
/**
 * Created by MoWagdy
 * Date: 2019-06-23
 * Time: 11:05 PM
 */

namespace App\Traits\Api;

use App\Http\Resources\AuthUsers\StudentLoginDTO;
use App\Models\User;
use Illuminate\Http\Request;

trait LoginTrait
{
    public function loginUser(User $user, Request $request)
    {
        if (!$user->phone_verified_at) {
            return response()->json(['message' => 'User did not verified'], 400);
        }
        auth()->loginUsingId($user->id);
        $user->update([
            'fcm_token' => $request['fcm_token'],
            'os_type' => $request['os_type'],
            'last_session_id' => session()->getId(),
            'last_ip' => $request->ip(),
        ]);

        return response()->json(new StudentLoginDTO($user), 200);
    }
}
