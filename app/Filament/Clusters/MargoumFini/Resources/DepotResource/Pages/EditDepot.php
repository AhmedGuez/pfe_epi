<?php

namespace App\Filament\Clusters\MargoumFini\Resources\DepotResource\Pages;

use App\Filament\Clusters\MargoumFini\Resources\DepotResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDepot extends EditRecord
{
    protected static string $resource = DepotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
