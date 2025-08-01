<?php

namespace App\Filament\Clusters\BonDeSortie\Resources\BnsSemiFiniRecapResource\Pages;

use App\Filament\Clusters\BonDeSortie\Resources\BnsSemiFiniRecapResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBnsSemiFiniRecap extends CreateRecord
{
    protected static string $resource = BnsSemiFiniRecapResource::class;

    protected function getRedirectUrl(): string 
    {
        return $this->getResource()::getUrl('index');
    }

}
