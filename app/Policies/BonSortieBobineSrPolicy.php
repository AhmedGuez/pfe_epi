<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\BonSortieBobineSr;
use App\Models\User;

class BonSortieBobineSrPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any BonSortieBobineSr');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BonSortieBobineSr $bonsortiebobinesr): bool
    {
        return $user->checkPermissionTo('view BonSortieBobineSr');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create BonSortieBobineSr');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BonSortieBobineSr $bonsortiebobinesr): bool
    {
        return $user->checkPermissionTo('update BonSortieBobineSr');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BonSortieBobineSr $bonsortiebobinesr): bool
    {
        return $user->checkPermissionTo('delete BonSortieBobineSr');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BonSortieBobineSr $bonsortiebobinesr): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BonSortieBobineSr $bonsortiebobinesr): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
