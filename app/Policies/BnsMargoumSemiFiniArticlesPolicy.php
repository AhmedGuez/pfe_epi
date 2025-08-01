<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\BnsMargoumSemiFiniArticles;
use App\Models\User;

class BnsMargoumSemiFiniArticlesPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any BnsMargoumSemiFiniArticles');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BnsMargoumSemiFiniArticles $bnsmargoumsemifiniarticles): bool
    {
        return $user->checkPermissionTo('view BnsMargoumSemiFiniArticles');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create BnsMargoumSemiFiniArticles');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BnsMargoumSemiFiniArticles $bnsmargoumsemifiniarticles): bool
    {
        return $user->checkPermissionTo('update BnsMargoumSemiFiniArticles');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BnsMargoumSemiFiniArticles $bnsmargoumsemifiniarticles): bool
    {
        return $user->checkPermissionTo('delete BnsMargoumSemiFiniArticles');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BnsMargoumSemiFiniArticles $bnsmargoumsemifiniarticles): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BnsMargoumSemiFiniArticles $bnsmargoumsemifiniarticles): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
