<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\ProductionFringe;
use App\Models\User;

class ProductionFringePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any ProductionFringe');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ProductionFringe $productionfringe): bool
    {
        return $user->checkPermissionTo('view ProductionFringe');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create ProductionFringe');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ProductionFringe $productionfringe): bool
    {
        return $user->checkPermissionTo('update ProductionFringe');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ProductionFringe $productionfringe): bool
    {
        return $user->checkPermissionTo('delete ProductionFringe');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ProductionFringe $productionfringe): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ProductionFringe $productionfringe): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
