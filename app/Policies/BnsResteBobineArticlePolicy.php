<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\BnsResteBobineArticle;
use App\Models\User;

class BnsResteBobineArticlePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any BnsResteBobineArticle');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BnsResteBobineArticle $bnsrestebobinearticle): bool
    {
        return $user->checkPermissionTo('view BnsResteBobineArticle');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create BnsResteBobineArticle');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BnsResteBobineArticle $bnsrestebobinearticle): bool
    {
        return $user->checkPermissionTo('update BnsResteBobineArticle');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BnsResteBobineArticle $bnsrestebobinearticle): bool
    {
        return $user->checkPermissionTo('delete BnsResteBobineArticle');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BnsResteBobineArticle $bnsrestebobinearticle): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BnsResteBobineArticle $bnsrestebobinearticle): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
