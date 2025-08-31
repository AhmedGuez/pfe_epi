<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommandePrintController extends Controller
{
    public function print(Commande $commande)
    {
        $user = Auth::user();

        // Check if user has permission to print this commande
        if ($user->hasRole('Client')) {
            // Client users can only print their own commandes
            $userClientIds = $user->clients()->pluck('clients.id');
            
            if (!$userClientIds->contains($commande->client_id)) {
                abort(403, 'Vous n\'avez pas la permission d\'imprimer cette commande.');
            }
        } elseif (!$user->hasRole('Superadmin') && !$user->hasRole('Superviseur') && !$user->hasRole('rh') && !$user->hasRole('Agent Commercial')) {
            // Non-admin users cannot print commandes
            abort(403, 'Vous n\'avez pas la permission d\'imprimer les commandes.');
        }

        // Load the commande with its relationships
        $commande->load(['client', 'commandeArticles.product']);

        return view('print.commande', compact('commande'));
    }
} 