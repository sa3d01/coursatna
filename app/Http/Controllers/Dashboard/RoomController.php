<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\RoomStoreRequest;
use App\Http\Requests\Dashboard\RoomUpdateRequest;
use App\Models\ChatRoom;
use App\Http\Controllers\Controller;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(ChatRoom::class, 'room');
    }

    public function index()
    {
        return view('dashboard.rooms.index')
            ->with('rooms', ChatRoom::orderBy('id', 'desc')->paginate())
            ->with('total', ChatRoom::count())
            ->with('indexUrl', route('dashboard.rooms.index'));
    }

    public function create()
    {
        return view('dashboard.rooms.create');
    }

    public function store(RoomStoreRequest $request)
    {
        ChatRoom::create($request->validated());
        return redirect()->route('dashboard.rooms.index')
            ->with('message', trans('crud.success.store'))->with('class', 'alert-success');
    }

    public function show(ChatRoom $room)
    {
        return redirect()->route('dashboard.rooms.edit', $room['id']);
    }

    public function edit(ChatRoom $room)
    {
        return view('dashboard.rooms.edit')
            ->with('room', $room);
    }

    public function update(RoomUpdateRequest $request, ChatRoom $room)
    {
        $room->update($request->validated());
        return redirect()->route('dashboard.rooms.index')
            ->with('message', trans('crud.success.update'))->with('class', 'alert-success');
    }

    public function destroy(ChatRoom $room)
    {
        $room->delete();
        return redirect()->route('dashboard.rooms.index')
            ->with('message', trans('crud.success.delete'))->with('class', 'alert-success');
    }
}
