<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\SousTraitanceControlle;
use App\Models\User;

class SousTraitanceControllePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any SousTraitanceControlle');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SousTraitanceControlle $soustraitancecontrolle): bool
    {
        return $user->checkPermissionTo('view SousTraitanceControlle');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create SousTraitanceControlle');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SousTraitanceControlle $soustraitancecontrolle): bool
    {
        return $user->checkPermissionTo('update SousTraitanceControlle');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SousTraitanceControlle $soustraitancecontrolle): bool
    {
        return $user->checkPermissionTo('delete SousTraitanceControlle');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SousTraitanceControlle $soustraitancecontrolle): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SousTraitanceControlle $soustraitancecontrolle): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
