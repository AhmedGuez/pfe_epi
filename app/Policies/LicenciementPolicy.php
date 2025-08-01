<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Licenciement;
use App\Models\User;

class LicenciementPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any Licenciement');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Licenciement $licenciement): bool
    {
        return $user->checkPermissionTo('view Licenciement');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create Licenciement');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Licenciement $licenciement): bool
    {
        return $user->checkPermissionTo('update Licenciement');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Licenciement $licenciement): bool
    {
        return $user->checkPermissionTo('delete Licenciement');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Licenciement $licenciement): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Licenciement $licenciement): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
