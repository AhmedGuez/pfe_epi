<?php

namespace App\Filament\Clusters\Requetes\Resources\AbsencesResource\Pages;

use App\Filament\Clusters\Requetes\Resources\AbsencesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAbsences extends CreateRecord
{
    protected static string $resource = AbsencesResource::class;
    protected function getRedirectUrl(): string 
    {
        return $this->getResource()::getUrl('index');
    }
}
