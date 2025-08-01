<?php

namespace App\Filament\Exports;

use App\Models\Article;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ArticlesExporter extends Exporter
{
    protected static ?string $model = Article::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make(name: 'id')->label('id'),
            ExportColumn::make(name: 'code_article')->label('Référance Article'),
            ExportColumn::make(name: 'couleur')->label('Couleur'),
            ExportColumn::make(name: 'largeur')->label('Largeur'),
            ExportColumn::make(name: 'hauteur')->label('Hauteur'),
            ExportColumn::make(name: 'coefficient_metrage')->label('Coefficient Metrage'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your articles export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
