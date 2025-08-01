<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\StockFringeNonNouee;
use App\Models\User;

class StockFringeNonNoueePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any StockFringeNonNouee');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, StockFringeNonNouee $stockfringenonnouee): bool
    {
        return $user->checkPermissionTo('view StockFringeNonNouee');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create StockFringeNonNouee');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, StockFringeNonNouee $stockfringenonnouee): bool
    {
        return $user->checkPermissionTo('update StockFringeNonNouee');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, StockFringeNonNouee $stockfringenonnouee): bool
    {
        return $user->checkPermissionTo('delete StockFringeNonNouee');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, StockFringeNonNouee $stockfringenonnouee): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, StockFringeNonNouee $stockfringenonnouee): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
