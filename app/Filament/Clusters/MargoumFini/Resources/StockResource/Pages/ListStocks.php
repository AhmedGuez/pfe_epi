<?php

namespace App\Filament\Clusters\MargoumFini\Resources\StockResource\Pages;

use App\Filament\Clusters\MargoumFini\Resources\StockResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStocks extends ListRecords
{
    protected static string $resource = StockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
