<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Subject;
use Illuminate\Auth\Access\HandlesAuthorization;

class SchoolSubjectPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->can('view-school-subjects');
    }

    public function view(User $user, Subject $model)
    {
        return $user->can('view-school-subjects');
    }

    public function create(User $user)
    {
        return $user->can('create-school-subjects');
    }

    public function update(User $user, Subject $model)
    {
        return $user->can('edit-school-subjects');
    }

    public function delete(User $user, Subject $model)
    {
        return $user->can('delete-school-subjects');
    }

    public function restore(User $user, Subject $model)
    {
        //
    }

    public function forceDelete(User $user, Subject $model)
    {
        return true;
    }
}
