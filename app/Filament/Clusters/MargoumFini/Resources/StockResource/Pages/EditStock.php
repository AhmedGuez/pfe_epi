<?php

namespace App\Filament\Clusters\MargoumFini\Resources\StockResource\Pages;

use App\Filament\Clusters\MargoumFini\Resources\StockResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStock extends EditRecord
{
    protected static string $resource = StockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
