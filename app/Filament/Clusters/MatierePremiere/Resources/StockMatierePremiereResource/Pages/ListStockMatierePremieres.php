<?php

namespace App\Filament\Clusters\MatierePremiere\Resources\StockMatierePremiereResource\Pages;

use App\Filament\Clusters\MatierePremiere\Resources\StockMatierePremiereResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStockMatierePremieres extends ListRecords
{
    protected static string $resource = StockMatierePremiereResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
