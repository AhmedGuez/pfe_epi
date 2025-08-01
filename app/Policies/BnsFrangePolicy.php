<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\BnsFrange;
use App\Models\User;

class BnsFrangePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any BnsFrange');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BnsFrange $bnsfrange): bool
    {
        return $user->checkPermissionTo('view BnsFrange');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create BnsFrange');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BnsFrange $bnsfrange): bool
    {
        return $user->checkPermissionTo('update BnsFrange');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BnsFrange $bnsfrange): bool
    {
        return $user->checkPermissionTo('delete BnsFrange');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BnsFrange $bnsfrange): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BnsFrange $bnsfrange): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
