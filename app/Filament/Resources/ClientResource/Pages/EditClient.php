<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Resources\ClientResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;

class EditClient extends EditRecord
{
    protected static string $resource = ClientResource::class;

    protected $password = null;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Extract password from the form data
        $password = $data['password'] ?? null;
        
        // Remove password from client data
        unset($data['password']);
        
        // Store password in the record for later use
        $this->password = $password;
        
        return $data;
    }

    protected function afterSave(): void
    {
        $client = $this->record;
        $password = $this->password;
        
        // If password was provided, update the associated user's password
        if ($password && $client->user_id) {
            $user = User::find($client->user_id);
            if ($user) {
                $user->update([
                    'password' => Hash::make($password),
                ]);
                
                // Show success message using Filament's notification system
                $this->getSavedNotification()?->send();
            }
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
    
    protected function getRedirectUrl(): string 
    {
        return $this->getResource()::getUrl('index');
    }
}
