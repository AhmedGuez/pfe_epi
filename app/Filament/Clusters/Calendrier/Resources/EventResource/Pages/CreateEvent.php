<?php

namespace App\Filament\Clusters\Calendrier\Resources\EventResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Clusters\Calendrier\Resources\EventResource;

class CreateEvent extends CreateRecord
{
    protected static string $resource = EventResource::class;
}
