<?php
namespace App\Filament\Exports;

use App\Models\Employees;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use App\Enums\ContractType;
use Carbon\Carbon;

class EmployeesExporter extends Exporter
{
    protected static ?string $model = Employees::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('id'),
            ExportColumn::make('code')
                ->label('code'),
            ExportColumn::make('full_name')
                ->label('Nom et Prenom'),
            ExportColumn::make('hire_date')
                ->label("Date d'embauche"),
            ExportColumn::make('contract_type')
                ->label('Type de contrat'),
            ExportColumn::make('post')
                ->label('Poste'),
            ExportColumn::make('affected')
                ->label('Affected'),
            ExportColumn::make('cin')
                ->label('Cin'),
            ExportColumn::make('phone_number')
                ->label('N° Telephone'),
            ExportColumn::make('address')
                ->label('Adresse'),
            ExportColumn::make('situation')
            ->label('situation'),
            ExportColumn::make('nombre_enfants')
            ->label('nombre enfants'),
            ExportColumn::make('prix_heure')
                ->label("Prix D'heure"),
        ];
    }
    
    public static function formatExportRow($row): array
    {
        // Format hire_date using null coalescing and optional parsing
        if (!empty($row['hire_date'])) {
            try {
                $row['hire_date'] = Carbon::parse($row['hire_date'])->format('d/m/Y');
            } catch (\Exception) {
                $row['hire_date'] = 'Invalid Date';
            }
        }

        // Convert contract_type using tryFrom for better performance
        if (!empty($row['contract_type'])) {
            $row['contract_type'] = ContractType::tryFrom($row['contract_type'])?->getLabel() ?? 'Unknown';
        }

        return $row;
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your employees export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}