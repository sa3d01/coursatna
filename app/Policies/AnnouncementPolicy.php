<?php

namespace App\Policies;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnnouncementPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->can('view-announcements');
    }

    public function view(User $user, Announcement $model)
    {
        return $user->can('view-announcements');
    }

    public function create(User $user)
    {
        return $user->can('create-announcements');
    }

    public function update(User $user, Announcement $model)
    {
        return $user->can('edit-announcements');
    }

    public function delete(User $user, Announcement $model)
    {
        return $user->can('delete-announcements');
    }

    public function restore(User $user, Announcement $model)
    {
        //
    }

    public function forceDelete(User $user, Announcement $model)
    {
        return $user->can('delete-announcements');
    }
}
