<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\CaseModel;
use App\Models\User;

class CaseModelPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any CaseModel');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CaseModel $casemodel): bool
    {
        return $user->checkPermissionTo('view CaseModel');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create CaseModel');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CaseModel $casemodel): bool
    {
        return $user->checkPermissionTo('update CaseModel');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CaseModel $casemodel): bool
    {
        return $user->checkPermissionTo('delete CaseModel');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CaseModel $casemodel): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CaseModel $casemodel): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
