<?php

namespace App\Policies;

use App\Models\BannedWord;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BannedWordPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return $user->can('view-banned-words');
    }

    public function view(User $user, BannedWord $model)
    {
        return $user->can('view-banned-words');
    }

    public function create(User $user)
    {
        return $user->can('create-banned-words');
    }

    public function update(User $user, BannedWord $model)
    {
        return $user->can('edit-banned-words');
    }

    public function delete(User $user, BannedWord $model)
    {
        return $user->can('delete-banned-words');
    }

    public function restore(User $user, BannedWord $model)
    {
        //
    }

    public function forceDelete(User $user, BannedWord $model)
    {
        return true;
    }
}
