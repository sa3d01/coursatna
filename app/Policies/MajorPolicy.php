<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Major;
use Illuminate\Auth\Access\HandlesAuthorization;

class MajorPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->can('view-majors');
    }

    public function view(User $user, Major $model)
    {
        return $user->can('view-majors');
    }

    public function create(User $user)
    {
        return $user->can('create-majors');
    }

    public function update(User $user, Major $model)
    {
        return $user->can('edit-majors');
    }

    public function delete(User $user, Major $model)
    {
        return $user->can('delete-majors');
    }

    public function restore(User $user, Major $model)
    {
        //
    }

    public function forceDelete(User $user, Major $model)
    {
        return true;
    }
}
