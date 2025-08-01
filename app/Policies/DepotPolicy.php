<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Depot;
use App\Models\User;

class DepotPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any Depot');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Depot $depot): bool
    {
        return $user->checkPermissionTo('view Depot');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create Depot');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Depot $depot): bool
    {
        return $user->checkPermissionTo('update Depot');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Depot $depot): bool
    {
        return $user->checkPermissionTo('delete Depot');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Depot $depot): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Depot $depot): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
