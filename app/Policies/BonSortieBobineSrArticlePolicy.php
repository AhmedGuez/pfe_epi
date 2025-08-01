<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\BonSortieBobineSrArticle;
use App\Models\User;

class BonSortieBobineSrArticlePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any BonSortieBobineSrArticle');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BonSortieBobineSrArticle $bonsortiebobinesrarticle): bool
    {
        return $user->checkPermissionTo('view BonSortieBobineSrArticle');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create BonSortieBobineSrArticle');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BonSortieBobineSrArticle $bonsortiebobinesrarticle): bool
    {
        return $user->checkPermissionTo('update BonSortieBobineSrArticle');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BonSortieBobineSrArticle $bonsortiebobinesrarticle): bool
    {
        return $user->checkPermissionTo('delete BonSortieBobineSrArticle');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BonSortieBobineSrArticle $bonsortiebobinesrarticle): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BonSortieBobineSrArticle $bonsortiebobinesrarticle): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
