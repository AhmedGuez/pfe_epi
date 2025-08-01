<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Fournisseur;
use App\Models\User;

class FournisseurPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any Fournisseur');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Fournisseur $fournisseur): bool
    {
        return $user->checkPermissionTo('view Fournisseur');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create Fournisseur');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Fournisseur $fournisseur): bool
    {
        return $user->checkPermissionTo('update Fournisseur');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Fournisseur $fournisseur): bool
    {
        return $user->checkPermissionTo('delete Fournisseur');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Fournisseur $fournisseur): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Fournisseur $fournisseur): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
