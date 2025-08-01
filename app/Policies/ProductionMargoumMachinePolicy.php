<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\ProductionMargoumMachine;
use App\Models\User;

class ProductionMargoumMachinePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any ProductionMargoumMachine');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ProductionMargoumMachine $productionmargoummachine): bool
    {
        return $user->checkPermissionTo('view ProductionMargoumMachine');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create ProductionMargoumMachine');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ProductionMargoumMachine $productionmargoummachine): bool
    {
        return $user->checkPermissionTo('update ProductionMargoumMachine');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ProductionMargoumMachine $productionmargoummachine): bool
    {
        return $user->checkPermissionTo('delete ProductionMargoumMachine');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ProductionMargoumMachine $productionmargoummachine): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ProductionMargoumMachine $productionmargoummachine): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
