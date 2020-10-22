<?php

namespace App\Http\Controllers\Api\Notification;

use App\Http\Controllers\Controller;
use App\Http\Resources\Notification\NotificationDTO;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        return NotificationDTO::collection(Notification::where('notifiable_id',request()->user()->id)->paginate());
    }
}
