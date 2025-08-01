<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\BnsFrangeArticle;
use App\Models\User;

class BnsFrangeArticlePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any BnsFrangeArticle');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BnsFrangeArticle $bnsfrangearticle): bool
    {
        return $user->checkPermissionTo('view BnsFrangeArticle');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create BnsFrangeArticle');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BnsFrangeArticle $bnsfrangearticle): bool
    {
        return $user->checkPermissionTo('update BnsFrangeArticle');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BnsFrangeArticle $bnsfrangearticle): bool
    {
        return $user->checkPermissionTo('delete BnsFrangeArticle');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BnsFrangeArticle $bnsfrangearticle): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BnsFrangeArticle $bnsfrangearticle): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
