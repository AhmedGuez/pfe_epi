<?php

namespace App\Filament\Resources\DemandeAchatsResource\Pages;

use App\Filament\Resources\DemandeAchatsResource;
use App\Models\DemandeAchat;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateDemandeAchats extends CreateRecord
{
    protected static string $resource = DemandeAchatsResource::class;


    protected function getRedirectUrl(): string 
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        /** @var DemandeAchat $commande */
        $demandeAchat = $this->record;
    
        // Fetch all users with the 'admin' role
        $adminUsers = User::role('Super Admin')->get();
    
        foreach ($adminUsers as $user) {
            Notification::make()
            ->title('New Demande Achat')
            ->icon('heroicon-o-shopping-bag')
            ->body("**{$demandeAchat->created_by} created a demande achat for {$demandeAchat->quantite} items.**")
            ->actions([
                Action::make('View')
                    ->url(route('filament.admin.resources.demande-achats.view', ['record' => $demandeAchat->id]))
                    ->openUrlInNewTab(true),
            ])
                ->sendToDatabase($user);
        }
    }
    
    
}
