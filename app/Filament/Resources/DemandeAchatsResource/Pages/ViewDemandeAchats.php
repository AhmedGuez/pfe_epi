<?php

namespace App\Filament\Resources\DemandeAchatsResource\Pages;

use App\Filament\Resources\DemandeAchatsResource;
use App\Models\DemandeAchat;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;


class ViewDemandeAchats extends ViewRecord
{
    protected static string $resource = DemandeAchatsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),

            Action::make('downloadFile')
            ->label('Télécharger le fichier Joint')
            ->icon('heroicon-o-arrow-down-tray')
            ->color('success')
            ->url(fn(DemandeAchat $record) => route('demande.download', $record))
            ->openUrlInNewTab()
        ];
    }
}
