<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\BneMatierePremiere;
use App\Models\User;

class BneMatierePremierePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any BneMatierePremiere');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BneMatierePremiere $bnematierepremiere): bool
    {
        return $user->checkPermissionTo('view BneMatierePremiere');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create BneMatierePremiere');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BneMatierePremiere $bnematierepremiere): bool
    {
        return $user->checkPermissionTo('update BneMatierePremiere');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BneMatierePremiere $bnematierepremiere): bool
    {
        return $user->checkPermissionTo('delete BneMatierePremiere');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BneMatierePremiere $bnematierepremiere): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BneMatierePremiere $bnematierepremiere): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
