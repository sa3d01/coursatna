<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Item;
use Illuminate\Auth\Access\HandlesAuthorization;

class ItemPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->can('view-items');
    }

    public function view(User $user, Item $model)
    {
        return $user->can('view-items');
    }

    public function create(User $user)
    {
        return $user->can('create-items');
    }

    public function update(User $user, Item $model)
    {
        return $user->can('edit-items');
    }

    public function delete(User $user, Item $model)
    {
        return $user->can('delete-items');
    }

    public function restore(User $user, Item $model)
    {
        //
    }

    public function forceDelete(User $user, Item $model)
    {
        return true;
    }
}
