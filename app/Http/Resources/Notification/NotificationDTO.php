<?php

namespace App\Http\Resources\Notification;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationDTO extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */

    public function toArray($request)
    {
        return [
            'id' => (int)$this->id,
            'type' => $this->type,
            'notifiable_type' => $this->notifiable_type,
            'data' => $this->data,
        ];
    }
}
