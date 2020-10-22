<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\RoomMember;
use App\Models\RoomRequest;
use App\Http\Controllers\Controller;

class RoomRequestController extends Controller
{
    public function pending($roomId)
    {
        return view('dashboard.rooms.requests.pending')
            ->with('requests', RoomRequest::where([
                'chat_room_id' => $roomId,
                'status' => 'PENDING',
            ])->orderBy('id', 'desc')->paginate())
            ->with('total', RoomRequest::where([
                'chat_room_id' => $roomId,
                'status' => 'PENDING',
            ])->count());
    }

    public function accept($roomId, $requestId)
    {
        $roomRequest = RoomRequest::find($requestId);
        $roomRequest->update(['status' => 'APPROVED']);
        RoomMember::create([
            'chat_room_id' => $roomId,
            'user_id' => $roomRequest->user_id,
        ]);
        return redirect()->route('dashboard.rooms.index')
            ->with('message', trans('crud.success.update'))->with('class', 'alert-success');
    }

    public function reject($roomId, $requestId)
    {
        $request = RoomRequest::find($requestId);
        $request->update(['status' => 'REJECTED']);
        return redirect()->route('dashboard.rooms.index')
            ->with('message', trans('crud.success.update'))->with('class', 'alert-success');
    }
}
