<?php

namespace App\Filament\Clusters\Paie\Resources\PointageResource\Pages;

use App\Filament\Clusters\Paie\Resources\PointageResource;
use App\Filament\Imports\PointageImporter;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPointages extends ListRecords
{
    protected static string $resource = PointageResource::class;
    protected function getHeaderActions(): array
    {
        return [
            // Actions\ImportAction::make()
            //     ->importer(PointageImporter::class)
            //     ->label('Import Excel'),
            // Actions\CreateAction::make()
            //     ->label('+'),
            Actions\Action::make('markAttendance')
                ->label('Pointage')
                ->color('primary')
                ->icon('heroicon-o-pencil')
                ->url('/admin/rh/paie/pointages/mark-attendance'),
        ];
    }
    
    
}
