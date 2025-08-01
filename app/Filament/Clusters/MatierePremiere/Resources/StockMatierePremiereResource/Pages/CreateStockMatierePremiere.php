<?php

namespace App\Filament\Clusters\MatierePremiere\Resources\StockMatierePremiereResource\Pages;

use App\Filament\Clusters\MatierePremiere\Resources\StockMatierePremiereResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateStockMatierePremiere extends CreateRecord
{
    protected static string $resource = StockMatierePremiereResource::class;

    protected function getRedirectUrl(): string 
    {
        return $this->getResource()::getUrl('index');
    }
}
