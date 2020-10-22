<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UniversitySubject;
use Illuminate\Auth\Access\HandlesAuthorization;

class UniversitySubjectPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->can('view-university-subjects');
    }

    public function view(User $user, UniversitySubject $model)
    {
        return $user->can('view-university-subjects');
    }

    public function create(User $user)
    {
        return $user->can('create-university-subjects');
    }

    public function update(User $user, UniversitySubject $model)
    {
        return $user->can('edit-university-subjects');
    }

    public function delete(User $user, UniversitySubject $model)
    {
        return $user->can('delete-university-subjects');
    }

    public function restore(User $user, UniversitySubject $model)
    {
        //
    }

    public function forceDelete(User $user, UniversitySubject $model)
    {
        return true;
    }
}
