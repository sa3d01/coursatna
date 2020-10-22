<?php

namespace App\Policies;

use App\Models\User;
use App\Models\University;
use Illuminate\Auth\Access\HandlesAuthorization;

class UniversityPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->can('view-universities');
    }

    public function view(User $user, University $model)
    {
        return $user->can('view-universities');
    }

    public function create(User $user)
    {
        return $user->can('create-universities');
    }

    public function update(User $user, University $model)
    {
        return $user->can('edit-universities');
    }

    public function delete(User $user, University $model)
    {
        return $user->can('delete-universities');
    }

    public function restore(User $user, University $model)
    {
        //
    }

    public function forceDelete(User $user, University $model)
    {
        return true;
    }
}
