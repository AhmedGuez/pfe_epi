<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\BnsMargoumArticle;
use App\Models\User;

class BnsMargoumArticlePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any BnsMargoumArticle');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BnsMargoumArticle $bnsmargoumarticle): bool
    {
        return $user->checkPermissionTo('view BnsMargoumArticle');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create BnsMargoumArticle');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BnsMargoumArticle $bnsmargoumarticle): bool
    {
        return $user->checkPermissionTo('update BnsMargoumArticle');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BnsMargoumArticle $bnsmargoumarticle): bool
    {
        return $user->checkPermissionTo('delete BnsMargoumArticle');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BnsMargoumArticle $bnsmargoumarticle): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BnsMargoumArticle $bnsmargoumarticle): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
