<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\CommandeArticle;
use App\Models\User;

class CommandeArticlePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any CommandeArticle');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CommandeArticle $commandearticle): bool
    {
        return $user->checkPermissionTo('view CommandeArticle');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create CommandeArticle');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CommandeArticle $commandearticle): bool
    {
        return $user->checkPermissionTo('update CommandeArticle');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CommandeArticle $commandearticle): bool
    {
        return $user->checkPermissionTo('delete CommandeArticle');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CommandeArticle $commandearticle): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CommandeArticle $commandearticle): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
