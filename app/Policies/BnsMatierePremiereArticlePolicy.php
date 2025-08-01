<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\BnsMatierePremiereArticle;
use App\Models\User;

class BnsMatierePremiereArticlePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any BnsMatierePremiereArticle');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BnsMatierePremiereArticle $bnsmatierepremierearticle): bool
    {
        return $user->checkPermissionTo('view BnsMatierePremiereArticle');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create BnsMatierePremiereArticle');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BnsMatierePremiereArticle $bnsmatierepremierearticle): bool
    {
        return $user->checkPermissionTo('update BnsMatierePremiereArticle');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BnsMatierePremiereArticle $bnsmatierepremierearticle): bool
    {
        return $user->checkPermissionTo('delete BnsMatierePremiereArticle');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BnsMatierePremiereArticle $bnsmatierepremierearticle): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BnsMatierePremiereArticle $bnsmatierepremierearticle): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
