<?php

namespace App\Policies;

use App\Models\ChatRoom;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RoomPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->can('view-rooms');
    }

    public function view(User $user, ChatRoom $model)
    {
        return $user->can('view-rooms');
    }

    public function create(User $user)
    {
        return $user->can('create-rooms');
    }

    public function update(User $user, ChatRoom $model)
    {
        return $user->can('edit-rooms');
    }

    public function delete(User $user, ChatRoom $model)
    {
        return $user->can('delete-rooms');
    }

    public function restore(User $user, ChatRoom $model)
    {
        //
    }

    public function forceDelete(User $user, ChatRoom $model)
    {
        return true;
    }
}
