<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\BncMatierePremiere;
use App\Models\User;

class BncMatierePremierePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any BncMatierePremiere');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BncMatierePremiere $bncmatierepremiere): bool
    {
        return $user->checkPermissionTo('view BncMatierePremiere');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create BncMatierePremiere');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BncMatierePremiere $bncmatierepremiere): bool
    {
        return $user->checkPermissionTo('update BncMatierePremiere');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BncMatierePremiere $bncmatierepremiere): bool
    {
        return $user->checkPermissionTo('delete BncMatierePremiere');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BncMatierePremiere $bncmatierepremiere): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BncMatierePremiere $bncmatierepremiere): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
