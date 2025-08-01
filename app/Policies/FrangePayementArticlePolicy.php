<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\FrangePayementArticle;
use App\Models\User;

class FrangePayementArticlePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any FrangePayementArticle');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, FrangePayementArticle $frangepayementarticle): bool
    {
        return $user->checkPermissionTo('view FrangePayementArticle');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create FrangePayementArticle');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, FrangePayementArticle $frangepayementarticle): bool
    {
        return $user->checkPermissionTo('update FrangePayementArticle');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, FrangePayementArticle $frangepayementarticle): bool
    {
        return $user->checkPermissionTo('delete FrangePayementArticle');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, FrangePayementArticle $frangepayementarticle): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, FrangePayementArticle $frangepayementarticle): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
