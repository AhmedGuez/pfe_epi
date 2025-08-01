<?php

namespace App\Filament\Clusters\MatierePremiere\Resources\RetourDeStockResource\Pages;

use App\Filament\Clusters\MatierePremiere\Resources\RetourDeStockResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRetourDeStocks extends ListRecords
{
    protected static string $resource = RetourDeStockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('+'),
        ];
    }
}
