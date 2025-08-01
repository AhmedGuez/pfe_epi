<?php

namespace App\Filament\Clusters\MargoumFini\Resources\PackageResource\Pages;

use App\Filament\Clusters\MargoumFini\Resources\PackageResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePackage extends CreateRecord
{
    protected static string $resource = PackageResource::class;

    protected function getRedirectUrl(): string 
    {
        return $this->getResource()::getUrl('index');
    }
}
