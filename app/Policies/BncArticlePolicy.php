<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\BncArticle;
use App\Models\User;

class BncArticlePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any BncArticle');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BncArticle $bncarticle): bool
    {
        return $user->checkPermissionTo('view BncArticle');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create BncArticle');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BncArticle $bncarticle): bool
    {
        return $user->checkPermissionTo('update BncArticle');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BncArticle $bncarticle): bool
    {
        return $user->checkPermissionTo('delete BncArticle');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BncArticle $bncarticle): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BncArticle $bncarticle): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
