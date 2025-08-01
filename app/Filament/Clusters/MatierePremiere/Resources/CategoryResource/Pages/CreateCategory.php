<?php

namespace App\Filament\Clusters\MatierePremiere\Resources\CategoryResource\Pages;

use App\Filament\Clusters\MatierePremiere\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getRedirectUrl(): string 
    {
        return $this->getResource()::getUrl('index');
    }
}
