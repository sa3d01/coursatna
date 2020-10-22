<?php

namespace App\Policies;

use App\Models\User;
use App\Models\City;
use Illuminate\Auth\Access\HandlesAuthorization;

class CityPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->can('view-cities');
    }

    public function view(User $user, City $model)
    {
        return $user->can('view-cities');
    }

    public function create(User $user)
    {
        return $user->can('create-cities');
    }

    public function update(User $user, City $model)
    {
        return $user->can('edit-cities');
    }

    public function delete(User $user, City $model)
    {
        return $user->can('delete-cities');
    }

    public function restore(User $user, City $model)
    {
        //
    }

    public function forceDelete(User $user, City $model)
    {
        return true;
    }
}
