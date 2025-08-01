<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\BnsMargoumSemiFini;
use App\Models\User;

class BnsMargoumSemiFiniPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any BnsMargoumSemiFini');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BnsMargoumSemiFini $bnsmargoumsemifini): bool
    {
        return $user->checkPermissionTo('view BnsMargoumSemiFini');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create BnsMargoumSemiFini');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BnsMargoumSemiFini $bnsmargoumsemifini): bool
    {
        return $user->checkPermissionTo('update BnsMargoumSemiFini');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BnsMargoumSemiFini $bnsmargoumsemifini): bool
    {
        return $user->checkPermissionTo('delete BnsMargoumSemiFini');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BnsMargoumSemiFini $bnsmargoumsemifini): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BnsMargoumSemiFini $bnsmargoumsemifini): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
