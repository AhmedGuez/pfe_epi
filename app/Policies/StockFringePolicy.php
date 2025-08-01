<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\StockFringe;
use App\Models\User;

class StockFringePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any StockFringe');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, StockFringe $stockfringe): bool
    {
        return $user->checkPermissionTo('view StockFringe');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create StockFringe');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, StockFringe $stockfringe): bool
    {
        return $user->checkPermissionTo('update StockFringe');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, StockFringe $stockfringe): bool
    {
        return $user->checkPermissionTo('delete StockFringe');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, StockFringe $stockfringe): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, StockFringe $stockfringe): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
