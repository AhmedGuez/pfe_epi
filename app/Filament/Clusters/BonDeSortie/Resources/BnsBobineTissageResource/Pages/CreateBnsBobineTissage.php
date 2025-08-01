<?php

namespace App\Filament\Clusters\BonDeSortie\Resources\BnsBobineTissageResource\Pages;

use App\Filament\Clusters\BonDeSortie\Resources\BnsBobineTissageResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBnsBobineTissage extends CreateRecord
{
    protected static string $resource = BnsBobineTissageResource::class;

    protected function getRedirectUrl(): string 
    {
        return $this->getResource()::getUrl('index');
    }

}
