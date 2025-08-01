<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\StockAdjustment;
use App\Models\User;

class StockAdjustmentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any StockAdjustment');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, StockAdjustment $stockadjustment): bool
    {
        return $user->checkPermissionTo('view StockAdjustment');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create StockAdjustment');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, StockAdjustment $stockadjustment): bool
    {
        return $user->checkPermissionTo('update StockAdjustment');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, StockAdjustment $stockadjustment): bool
    {
        return $user->checkPermissionTo('delete StockAdjustment');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, StockAdjustment $stockadjustment): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, StockAdjustment $stockadjustment): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
