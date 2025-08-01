<?php

namespace App\Filament\Clusters\Paie\Resources\PointageResource\Pages;

use App\Filament\Clusters\Paie\Resources\PointageResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePointage extends CreateRecord
{
    protected static string $resource = PointageResource::class;
    protected function getRedirectUrl(): string 
    {
        return $this->getResource()::getUrl('index');
    }
}
