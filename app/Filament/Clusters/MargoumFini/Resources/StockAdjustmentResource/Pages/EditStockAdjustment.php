<?php

namespace App\Filament\Clusters\MargoumFini\Resources\StockAdjustmentResource\Pages;

use App\Filament\Clusters\MargoumFini\Resources\StockAdjustmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStockAdjustment extends EditRecord
{
    protected static string $resource = StockAdjustmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
