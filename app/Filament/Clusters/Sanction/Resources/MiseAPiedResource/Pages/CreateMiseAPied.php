<?php

namespace App\Filament\Clusters\Sanction\Resources\MiseAPiedResource\Pages;

use App\Filament\Clusters\Sanction\Resources\MiseAPiedResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMiseAPied extends CreateRecord
{
    protected static string $resource = MiseAPiedResource::class;
    protected function getRedirectUrl(): string 
    {
        return $this->getResource()::getUrl('index');
    }
}
