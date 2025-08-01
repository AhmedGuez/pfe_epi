<?php

namespace App\Filament\Clusters\Requetes\Resources\AvancesResource\Pages;

use App\Filament\Clusters\Requetes\Resources\AvancesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAvances extends EditRecord
{
    protected static string $resource = AvancesResource::class;
    protected function getRedirectUrl(): string 
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
