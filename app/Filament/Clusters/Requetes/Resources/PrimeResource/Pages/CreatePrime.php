<?php

namespace App\Filament\Clusters\Requetes\Resources\PrimeResource\Pages;

use App\Filament\Clusters\Requetes\Resources\PrimeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePrime extends CreateRecord
{
    protected static string $resource = PrimeResource::class;
    protected function getRedirectUrl(): string 
    {
        return $this->getResource()::getUrl('index');
    }
}
