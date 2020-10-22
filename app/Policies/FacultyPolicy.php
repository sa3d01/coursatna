<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Faculty;
use Illuminate\Auth\Access\HandlesAuthorization;

class FacultyPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->can('view-faculties');
    }

    public function view(User $user, Faculty $model)
    {
        return $user->can('view-faculties');
    }

    public function create(User $user)
    {
        return $user->can('create-faculties');
    }

    public function update(User $user, Faculty $model)
    {
        return $user->can('edit-faculties');
    }

    public function delete(User $user, Faculty $model)
    {
        return $user->can('delete-faculties');
    }

    public function restore(User $user, Faculty $model)
    {
        //
    }

    public function forceDelete(User $user, Faculty $model)
    {
        return true;
    }
}
