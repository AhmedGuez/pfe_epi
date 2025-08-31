<?php

namespace App\Filament\Resources\CommandeResource\Pages;

use App\Filament\Resources\CommandeResource;
use App\Models\Commande;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Actions\Action;

class CreateCommande extends CreateRecord
{

    protected ?string $heading = 'Créer une nouvelle commande';

    protected static string $resource = CommandeResource::class;

    protected function getRedirectUrl(): string 
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        /** @var Commande $commande */
        $commande = $this->record;
    
        // Fetch all users with the 'admin' role
        $adminUsers = User::role('Superadmin')->get();
    
        foreach ($adminUsers as $user) {
            Notification::make()
                ->title('New Commande')
                ->icon('heroicon-o-shopping-bag')
                ->body("**{$commande->client->name} ordered {$commande->commandeArticles->count()} products.**")
                ->actions([
                    Action::make('View')
                        ->url(route('suivi.pdf.download', ['record' => $commande->id]))->openUrlInNewTab(true),
                ])
                ->sendToDatabase($user);
        }
    }
    
}
