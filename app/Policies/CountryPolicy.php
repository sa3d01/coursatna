<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Country;
use Illuminate\Auth\Access\HandlesAuthorization;

class CountryPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->can('view-countries');
    }

    public function view(User $user, Country $model)
    {
        return $user->can('view-countries');
    }

    public function create(User $user)
    {
        return $user->can('create-countries');
    }

    public function update(User $user, Country $model)
    {
        return $user->can('edit-countries');
    }

    public function delete(User $user, Country $model)
    {
        return $user->can('delete-countries');
    }

    public function restore(User $user, Country $model)
    {
        //
    }

    public function forceDelete(User $user, Country $model)
    {
        return true;
    }
}
