<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientUserController extends Controller
{
    /**
     * Attach a user to a client.
     */
    public function attachUser(Request $request, Client $client)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:owner,manager,viewer',
            'is_primary' => 'boolean',
        ]);

        // Check if user is already attached to this client
        if ($client->users()->where('user_id', $request->user_id)->exists()) {
            return response()->json(['message' => 'User is already attached to this client'], 400);
        }

        // If setting as primary, remove primary from other users
        if ($request->is_primary) {
            $client->users()->updateExistingPivot($client->users()->pluck('user_id'), ['is_primary' => false]);
        }

        $client->users()->attach($request->user_id, [
            'role' => $request->role,
            'is_primary' => $request->is_primary ?? false,
        ]);

        // Assign client-specific permissions to the user
        $user = User::find($request->user_id);
        if ($user) {
            $user->givePermissionTo([
                'view commande',
                'view commande article',
                'view any commande',
                'view-own-commandes', // Keep for backward compatibility
                'print-own-commandes', // Keep for backward compatibility
            ]);
        }

        return response()->json(['message' => 'User attached successfully']);
    }

    /**
     * Detach a user from a client.
     */
    public function detachUser(Request $request, Client $client)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $client->users()->detach($request->user_id);

        return response()->json(['message' => 'User detached successfully']);
    }

    /**
     * Update user role for a client.
     */
    public function updateUserRole(Request $request, Client $client)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:owner,manager,viewer',
            'is_primary' => 'boolean',
        ]);

        $client->users()->updateExistingPivot($request->user_id, [
            'role' => $request->role,
            'is_primary' => $request->is_primary ?? false,
        ]);

        return response()->json(['message' => 'User role updated successfully']);
    }

    /**
     * Get all users for a client.
     */
    public function getClientUsers(Client $client)
    {
        $users = $client->users()->withPivot('role', 'is_primary')->get();
        
        return response()->json($users);
    }

    /**
     * Get all clients for a user.
     */
    public function getUserClients(Request $request)
    {
        $user = auth()->user();
        $clients = $user->clients()->withPivot('role', 'is_primary')->get();
        
        return response()->json($clients);
    }

    /**
     * Set primary user for a client.
     */
    public function setPrimaryUser(Request $request, Client $client)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // Remove primary from all users
        $client->users()->updateExistingPivot($client->users()->pluck('user_id'), ['is_primary' => false]);
        
        // Set new primary user
        $client->users()->updateExistingPivot($request->user_id, ['is_primary' => true]);

        return response()->json(['message' => 'Primary user set successfully']);
    }
}
