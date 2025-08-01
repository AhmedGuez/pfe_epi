<?php
namespace App\Filament\Exports;

use App\Models\StockMatierePremiere;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Database\Eloquent\Builder;

class StockMatierePremiereExporter extends Exporter
{
    protected static ?string $model = StockMatierePremiere::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('article.name')
                ->label('Article Name'),
            ExportColumn::make('category.name')
                ->label('Category Name'),
            ExportColumn::make('quantity')
                ->label('Quantity'),
            ExportColumn::make('unite')
                ->label('Unit'),
            ExportColumn::make('updated_at')
                ->label('Updated At'),
        ];
    }

    public static function query(): Builder
    {
        return StockMatierePremiere::query()
            ->select('stock_matiere_premieres.*', 'article_matiere_premieres.name as article_name', 'categories.name as category_name')
            ->leftJoin('article_matiere_premieres', 'stock_matiere_premieres.article_matiere_premiere_id', '=', 'article_matiere_premieres.id')
            ->leftJoin('categories', 'stock_matiere_premieres.categorie_id', '=', 'categories.id');
    }

    public static function map($record): array
    {
        return [
            'article_name' => $record->article_name,
            'category_name' => $record->category_name,
            'quantity' => $record->quantity,
            'unite' => $record->unite,
            'updated_at' => $record->updated_at->format('Y-m-d H:i:s'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your stock matiere premiere export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
