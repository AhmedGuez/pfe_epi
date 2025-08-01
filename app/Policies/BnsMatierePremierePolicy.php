<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\BnsMatierePremiere;
use App\Models\User;

class BnsMatierePremierePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any BnsMatierePremiere');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BnsMatierePremiere $bnsmatierepremiere): bool
    {
        return $user->checkPermissionTo('view BnsMatierePremiere');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create BnsMatierePremiere');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BnsMatierePremiere $bnsmatierepremiere): bool
    {
        return $user->checkPermissionTo('update BnsMatierePremiere');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BnsMatierePremiere $bnsmatierepremiere): bool
    {
        return $user->checkPermissionTo('delete BnsMatierePremiere');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BnsMatierePremiere $bnsmatierepremiere): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BnsMatierePremiere $bnsmatierepremiere): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
