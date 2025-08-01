<?php

namespace App\Filament\Clusters\Requetes\Resources\AvancesResource\Pages;

use App\Filament\Clusters\Requetes\Resources\AvancesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAvances extends CreateRecord
{
    protected static string $resource = AvancesResource::class;
    protected function getRedirectUrl(): string 
    {
        return $this->getResource()::getUrl('index');
    }
}
