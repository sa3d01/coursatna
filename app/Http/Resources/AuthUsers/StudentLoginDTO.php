<?php

namespace App\Http\Resources\AuthUsers;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentLoginDTO extends JsonResource
{
    public function toArray($request)
    {
        $tokenResult = $this->createToken('customer');
        $tokenResult->token->expires_at = Carbon::now()->addWeeks(1);

        return [
            "user" => new StudentUserDTO($this),

            "settings" => [
                'banned' => (boolean)$this->banned,
                'locale' => $this->locale,
                'notification_toggle' => (boolean)$this->notification_toggle,
            ],

            "access_token" => [
                'token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
            ],

        ];
    }
}
