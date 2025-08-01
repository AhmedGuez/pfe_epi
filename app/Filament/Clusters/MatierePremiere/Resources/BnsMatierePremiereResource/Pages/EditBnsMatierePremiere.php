<?php

namespace App\Filament\Clusters\MatierePremiere\Resources\BnsMatierePremiereResource\Pages;

use App\Filament\Clusters\MatierePremiere\Resources\BnsMatierePremiereResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBnsMatierePremiere extends EditRecord
{
    protected static string $resource = BnsMatierePremiereResource::class;

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
