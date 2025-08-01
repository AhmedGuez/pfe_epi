<?php

namespace App\Filament\Clusters\MatierePremiere\Resources\ArrivageMatierePremiereResource\Pages;

use App\Filament\Clusters\MatierePremiere\Resources\ArrivageMatierePremiereResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArrivageMatierePremiere extends EditRecord
{
    protected static string $resource = ArrivageMatierePremiereResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string 
    {
        return $this->getResource()::getUrl('index');
    }
}
