<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Resources\ClientResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateClient extends CreateRecord
{
    protected ?string $heading = 'Créer un nouveau client';

    protected static string $resource = ClientResource::class;

    protected $password = null;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Extract password from the form data
        $password = $data['password'] ?? null;
        
        // Remove password from client data
        unset($data['password']);
        
        // Store password in the record for later use
        $this->password = $password;
        
        return $data;
    }

    protected function afterCreate(): void
    {
        $client = $this->record;
        $password = $this->password ?? 'password123'; // Default password if not provided
        
        // Create a new user with the client's email
        $user = User::create([
            'name' => $client->nom . ' ' . $client->prenom,
            'email' => $client->email,
            'password' => Hash::make($password),
        ]);
        
        // Assign the 'client' role to the user
        $user->assignRole('client');
        
        // Assign client-specific permissions
        $user->givePermissionTo([
            'view commande',
            'view commande article',
            'view any commande',
            'view-own-commandes', // Keep for backward compatibility
            'print-own-commandes', // Keep for backward compatibility
        ]);
        
        // Set this user as the primary user for the client
        $client->update(['user_id' => $user->id]);
        
        // Create the client-user relationship
        $client->users()->attach($user->id, [
            'role' => 'owner',
            'is_primary' => true,
        ]);
        
        // Show success message using Filament's notification system
        $this->getCreatedNotification()?->send();
    }

    protected function getRedirectUrl(): string 
    {
        return $this->getResource()::getUrl('index');
    }
}
