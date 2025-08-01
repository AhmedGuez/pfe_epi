<?php

namespace App\Filament\Clusters\Sanction\Resources\LicenciementResource\Pages;

use App\Filament\Clusters\Sanction\Resources\LicenciementResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLicenciement extends CreateRecord
{
    protected static string $resource = LicenciementResource::class;

    protected function getRedirectUrl(): string 
    {
        return $this->getResource()::getUrl('index');
    }
}
