<?php

namespace App\Filament\Clusters\Calendrier\Resources\EventResource\Pages;

use App\Filament\Clusters\Calendrier\Resources\EventResource;
use App\Filament\Clusters\Calendrier\Resources\EventResource\Widgets\GlobalEventCalendarWidget as WidgetsGlobalEventCalendarWidget;
use App\Filament\Widgets\GlobalEventCalendarWidget;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEvents extends ListRecords
{
    protected static string $resource = EventResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            WidgetsGlobalEventCalendarWidget::class,
        ];
    }
}
