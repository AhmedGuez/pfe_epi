<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\MargoumPremierFiniArticle;
use App\Models\User;

class MargoumPremierFiniArticlePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any MargoumPremierFiniArticle');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MargoumPremierFiniArticle $margoumpremierfiniarticle): bool
    {
        return $user->checkPermissionTo('view MargoumPremierFiniArticle');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create MargoumPremierFiniArticle');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MargoumPremierFiniArticle $margoumpremierfiniarticle): bool
    {
        return $user->checkPermissionTo('update MargoumPremierFiniArticle');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MargoumPremierFiniArticle $margoumpremierfiniarticle): bool
    {
        return $user->checkPermissionTo('delete MargoumPremierFiniArticle');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MargoumPremierFiniArticle $margoumpremierfiniarticle): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MargoumPremierFiniArticle $margoumpremierfiniarticle): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
