<?php

namespace App\Filament\Clusters\BonDeSortie\Resources\BnsBobineResource\Pages;

use App\Filament\Clusters\BonDeSortie\Resources\BnsBobineResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBnsBobine extends CreateRecord
{
    protected static string $resource = BnsBobineResource::class;

    protected function getRedirectUrl(): string 
    {
        return $this->getResource()::getUrl('index');
    }

}
