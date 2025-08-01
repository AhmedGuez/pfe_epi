<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Absences;
use App\Models\User;

class AbsencesPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any Absences');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Absences $absences): bool
    {
        return $user->checkPermissionTo('view Absences');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create Absences');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Absences $absences): bool
    {
        return $user->checkPermissionTo('update Absences');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Absences $absences): bool
    {
        return $user->checkPermissionTo('delete Absences');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Absences $absences): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Absences $absences): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
