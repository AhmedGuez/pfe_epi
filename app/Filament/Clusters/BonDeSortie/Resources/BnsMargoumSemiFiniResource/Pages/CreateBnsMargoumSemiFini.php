<?php

namespace App\Filament\Clusters\BonDeSortie\Resources\BnsMargoumSemiFiniResource\Pages;

use App\Filament\Clusters\BonDeSortie\Resources\BnsMargoumSemiFiniResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBnsMargoumSemiFini extends CreateRecord
{
    protected static string $resource = BnsMargoumSemiFiniResource::class;

    protected function getRedirectUrl(): string 
    {
        return $this->getResource()::getUrl('index');
    }
}
