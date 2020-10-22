<?php

namespace App\Policies;

use App\Models\Field;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FieldPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->can('view-fields');
    }

    public function view(User $user, Field $model)
    {
        return $user->can('view-fields');
    }

    public function create(User $user)
    {
        return $user->can('create-fields');
    }

    public function update(User $user, Field $model)
    {
        return $user->can('edit-fields');
    }

    public function delete(User $user, Field $model)
    {
        return $user->can('delete-fields');
    }

    public function restore(User $user, Field $model)
    {
        //
    }

    public function forceDelete(User $user, Field $model)
    {
        return true;
    }
}
