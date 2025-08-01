<?php

namespace App\Filament\Clusters\Sanction\Resources\LicenciementResource\Pages;

use App\Filament\Clusters\Sanction\Resources\LicenciementResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLicenciement extends EditRecord
{

    protected static string $resource = LicenciementResource::class;

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
