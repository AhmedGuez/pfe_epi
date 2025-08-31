<?php

namespace App\Filament\Exports;

use App\Models\Client;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ClientsExporter extends Exporter
{
    protected static ?string $model = Client::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('code_client')
                ->label('Client Code'),
            ExportColumn::make('nom_client')
                ->label('Client Name'),
            ExportColumn::make('cin')
                ->label('CIN'),
            ExportColumn::make('phone')
                ->label('Phone'),
            ExportColumn::make('adresse')
                ->label('Address'),
            ExportColumn::make('about_client')
                ->label('About Client'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your clients export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
