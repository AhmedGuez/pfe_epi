<?php

namespace App\Filament\Resources\DemandeAchatsResource\Pages;

use App\Filament\Resources\DemandeAchatsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDemandeAchats extends EditRecord
{
    protected static string $resource = DemandeAchatsResource::class;


    protected function getRedirectUrl(): string 
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
