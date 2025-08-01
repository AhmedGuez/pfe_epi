<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\InterventionCost;
use App\Models\User;

class InterventionCostPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any InterventionCost');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, InterventionCost $interventioncost): bool
    {
        return $user->checkPermissionTo('view InterventionCost');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create InterventionCost');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, InterventionCost $interventioncost): bool
    {
        return $user->checkPermissionTo('update InterventionCost');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, InterventionCost $interventioncost): bool
    {
        return $user->checkPermissionTo('delete InterventionCost');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, InterventionCost $interventioncost): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, InterventionCost $interventioncost): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
