<?php

namespace App\Filament\Clusters\MatierePremiere\Resources\RetourDeStockResource\Pages;

use App\Filament\Clusters\MatierePremiere\Resources\RetourDeStockResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRetourDeStock extends CreateRecord
{
    protected static string $resource = RetourDeStockResource::class;

    protected function getRedirectUrl(): string 
    {
        return $this->getResource()::getUrl('index');
    }
}
