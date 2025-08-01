<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\BnsDechet;
use App\Models\User;

class BnsDechetPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any BnsDechet');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BnsDechet $bnsdechet): bool
    {
        return $user->checkPermissionTo('view BnsDechet');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create BnsDechet');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BnsDechet $bnsdechet): bool
    {
        return $user->checkPermissionTo('update BnsDechet');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BnsDechet $bnsdechet): bool
    {
        return $user->checkPermissionTo('delete BnsDechet');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BnsDechet $bnsdechet): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BnsDechet $bnsdechet): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
