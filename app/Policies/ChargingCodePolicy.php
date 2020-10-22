<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ChargingCode;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChargingCodePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any Charging codes.
     *
     * @param  \App\Models\User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->can('view-charging-codes');
    }

    /**
     * Determine whether the user can view the charging code.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\ChargingCode $chargingCode
     * @return mixed
     */
    public function view(User $user, ChargingCode $chargingCode)
    {
        return $user->can('view-charging-codes');
    }

    /**
     * Determine whether the user can create charging codes.
     *
     * @param  \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->can('create-charging-codes');
    }

    /**
     * Determine whether the user can update the charging code.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\ChargingCode $chargingCode
     * @return mixed
     */
    public function update(User $user, ChargingCode $chargingCode)
    {
        return $user->can('edit-charging-codes');
    }

    /**
     * Determine whether the user can delete the charging code.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\ChargingCode $chargingCode
     * @return mixed
     */
    public function delete(User $user, ChargingCode $chargingCode)
    {
        return $user->can('delete-charging-codes');
    }

    /**
     * Determine whether the user can restore the charging code.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\ChargingCode $chargingCode
     * @return mixed
     */
    public function restore(User $user, ChargingCode $chargingCode)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the charging code.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\ChargingCode $chargingCode
     * @return mixed
     */
    public function forceDelete(User $user, ChargingCode $chargingCode)
    {
        //
    }
}
