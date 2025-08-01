<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\ArivageMatierePremiereArticle;
use App\Models\User;

class ArivageMatierePremiereArticlePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any ArivageMatierePremiereArticle');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ArivageMatierePremiereArticle $arivagematierepremierearticle): bool
    {
        return $user->checkPermissionTo('view ArivageMatierePremiereArticle');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create ArivageMatierePremiereArticle');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ArivageMatierePremiereArticle $arivagematierepremierearticle): bool
    {
        return $user->checkPermissionTo('update ArivageMatierePremiereArticle');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ArivageMatierePremiereArticle $arivagematierepremierearticle): bool
    {
        return $user->checkPermissionTo('delete ArivageMatierePremiereArticle');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ArivageMatierePremiereArticle $arivagematierepremierearticle): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ArivageMatierePremiereArticle $arivagematierepremierearticle): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
