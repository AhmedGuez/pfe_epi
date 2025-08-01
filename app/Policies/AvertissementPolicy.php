<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Avertissement;
use App\Models\User;

class AvertissementPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any Avertissement');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Avertissement $avertissement): bool
    {
        return $user->checkPermissionTo('view Avertissement');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create Avertissement');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Avertissement $avertissement): bool
    {
        return $user->checkPermissionTo('update Avertissement');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Avertissement $avertissement): bool
    {
        return $user->checkPermissionTo('delete Avertissement');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Avertissement $avertissement): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Avertissement $avertissement): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
