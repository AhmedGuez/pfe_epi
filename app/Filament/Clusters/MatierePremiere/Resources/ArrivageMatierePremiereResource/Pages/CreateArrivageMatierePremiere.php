<?php

namespace App\Filament\Clusters\MatierePremiere\Resources\ArrivageMatierePremiereResource\Pages;

use App\Filament\Clusters\MatierePremiere\Resources\ArrivageMatierePremiereResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateArrivageMatierePremiere extends CreateRecord
{
    protected static string $resource = ArrivageMatierePremiereResource::class;
    protected function getRedirectUrl(): string 
    {
        return $this->getResource()::getUrl('index');
    }
}
