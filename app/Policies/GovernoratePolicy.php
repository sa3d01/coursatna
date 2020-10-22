<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Governorate;
use Illuminate\Auth\Access\HandlesAuthorization;

class GovernoratePolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->can('view-governorates');
    }

    public function view(User $user, Governorate $model)
    {
        return $user->can('view-governorates');
    }

    public function create(User $user)
    {
        return $user->can('create-governorates');
    }

    public function update(User $user, Governorate $model)
    {
        return $user->can('edit-governorates');
    }

    public function delete(User $user, Governorate $model)
    {
        return $user->can('delete-governorates');
    }

    public function restore(User $user, Governorate $model)
    {
        //
    }

    public function forceDelete(User $user, Governorate $model)
    {
        return true;
    }
}
