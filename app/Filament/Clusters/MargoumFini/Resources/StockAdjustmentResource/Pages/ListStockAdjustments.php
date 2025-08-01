<?php

namespace App\Filament\Clusters\MargoumFini\Resources\StockAdjustmentResource\Pages;

use App\Filament\Clusters\MargoumFini\Resources\StockAdjustmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStockAdjustments extends ListRecords
{
    protected static string $resource = StockAdjustmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('+'),
        ];
    }
}
