<?php

namespace App\Filament\Clusters\Sanction\Resources\MiseAPiedResource\Pages;

use App\Filament\Clusters\Sanction\Resources\MiseAPiedResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMiseAPied extends EditRecord
{
    protected static string $resource = MiseAPiedResource::class;
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
