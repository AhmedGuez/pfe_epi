<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\ProductionMargoum;
use App\Models\User;

class ProductionMargoumPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any ProductionMargoum');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ProductionMargoum $productionmargoum): bool
    {
        return $user->checkPermissionTo('view ProductionMargoum');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create ProductionMargoum');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ProductionMargoum $productionmargoum): bool
    {
        return $user->checkPermissionTo('update ProductionMargoum');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ProductionMargoum $productionmargoum): bool
    {
        return $user->checkPermissionTo('delete ProductionMargoum');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ProductionMargoum $productionmargoum): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ProductionMargoum $productionmargoum): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
