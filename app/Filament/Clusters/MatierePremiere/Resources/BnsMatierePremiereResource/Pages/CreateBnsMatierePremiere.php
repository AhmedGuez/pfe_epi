<?php

namespace App\Filament\Clusters\MatierePremiere\Resources\BnsMatierePremiereResource\Pages;

use App\Filament\Clusters\MatierePremiere\Resources\BnsMatierePremiereResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBnsMatierePremiere extends CreateRecord
{
    protected static string $resource = BnsMatierePremiereResource::class;

    protected function getRedirectUrl(): string 
    {
        return $this->getResource()::getUrl('index');
    }
}
