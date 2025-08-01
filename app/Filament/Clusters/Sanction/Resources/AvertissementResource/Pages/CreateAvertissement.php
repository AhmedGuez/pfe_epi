<?php

namespace App\Filament\Clusters\Sanction\Resources\AvertissementResource\Pages;

use App\Filament\Clusters\Sanction\Resources\AvertissementResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAvertissement extends CreateRecord
{
    protected static string $resource = AvertissementResource::class;

    protected function getRedirectUrl(): string 
    {
        return $this->getResource()::getUrl('index');
    }
}
