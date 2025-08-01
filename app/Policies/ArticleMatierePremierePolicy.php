<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\ArticleMatierePremiere;
use App\Models\User;

class ArticleMatierePremierePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any ArticleMatierePremiere');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ArticleMatierePremiere $articlematierepremiere): bool
    {
        return $user->checkPermissionTo('view ArticleMatierePremiere');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create ArticleMatierePremiere');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ArticleMatierePremiere $articlematierepremiere): bool
    {
        return $user->checkPermissionTo('update ArticleMatierePremiere');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ArticleMatierePremiere $articlematierepremiere): bool
    {
        return $user->checkPermissionTo('delete ArticleMatierePremiere');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ArticleMatierePremiere $articlematierepremiere): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ArticleMatierePremiere $articlematierepremiere): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
