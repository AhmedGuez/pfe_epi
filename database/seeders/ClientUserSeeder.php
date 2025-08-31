<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ClientUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure client role exists
        $clientRole = \Spatie\Permission\Models\Role::where('name', 'client')->first();
        if (!$clientRole) {
            \Spatie\Permission\Models\Role::create(['name' => 'client', 'guard_name' => 'web']);
        }

        // Create a test client with automatic user creation
        $client = Client::firstOrCreate(
            ['email' => 'client@example.com'],
            [
                'nom' => 'Test Client',
                'prenom' => 'John',
                'nom_entreprise' => 'Test Company',
                'telephone' => '+216 123 456',
                'adresse' => 'Test Address',
            ]
        );

        // Create user for this client if it doesn't exist
        $user = User::firstOrCreate(
            ['email' => 'client@example.com'],
            [
                'name' => 'Test Client John',
                'password' => Hash::make('password123'),
            ]
        );

        // Assign client role
        $user->assignRole('client');

        // Set user as primary for client
        $client->update(['user_id' => $user->id]);

        // Create the relationship
        if (!$client->users()->where('user_id', $user->id)->exists()) {
            $client->users()->attach($user->id, [
                'role' => 'owner',
                'is_primary' => true,
            ]);
        }

        $this->command->info('Client-User relationship seeded successfully!');
        $this->command->info("User: {$user->name} ({$user->email})");
        $this->command->info("Client: {$client->nom_entreprise} ({$client->email})");
        $this->command->info("Role: Client (Primary)");
        $this->command->info("Password: password123");
    }
}
