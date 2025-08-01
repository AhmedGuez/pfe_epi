<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\BackToStock;
use App\Models\User;

class BackToStockPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any BackToStock');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BackToStock $backtostock): bool
    {
        return $user->checkPermissionTo('view BackToStock');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create BackToStock');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BackToStock $backtostock): bool
    {
        return $user->checkPermissionTo('update BackToStock');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BackToStock $backtostock): bool
    {
        return $user->checkPermissionTo('delete BackToStock');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BackToStock $backtostock): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BackToStock $backtostock): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
