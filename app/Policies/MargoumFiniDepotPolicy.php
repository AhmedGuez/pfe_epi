<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\MargoumFiniDepot;
use App\Models\User;

class MargoumFiniDepotPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any MargoumFiniDepot');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MargoumFiniDepot $margoumfinidepot): bool
    {
        return $user->checkPermissionTo('view MargoumFiniDepot');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create MargoumFiniDepot');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MargoumFiniDepot $margoumfinidepot): bool
    {
        return $user->checkPermissionTo('update MargoumFiniDepot');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MargoumFiniDepot $margoumfinidepot): bool
    {
        return $user->checkPermissionTo('delete MargoumFiniDepot');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MargoumFiniDepot $margoumfinidepot): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MargoumFiniDepot $margoumfinidepot): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
