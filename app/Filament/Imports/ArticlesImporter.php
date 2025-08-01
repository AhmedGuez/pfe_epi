<?php

namespace App\Filament\Imports;

use App\Models\Article;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class ArticlesImporter extends Importer
{
    protected static ?string $model = Article::class;


    public static function getColumns(): array
    {
        return [
            ImportColumn::make('code_article')
                ->requiredMapping()
                ->rules(['required', 'string', 'max:255', 'unique:articles,code_article'])
                ->example('ART123'),

            ImportColumn::make('couleur')
                ->rules(['nullable', 'string', 'max:255'])
                ->example('Red'),

            ImportColumn::make('largeur')
                ->rules(['nullable', 'numeric', 'min:0'])
                ->example('120.5'),

            ImportColumn::make('hauteur')
                ->rules(['nullable', 'numeric', 'min:0'])
                ->example('200.5'),

            ImportColumn::make('coefficient_metrage')
                ->rules(['nullable', 'numeric', 'min:0'])
                ->example('1.25'),
        ];
    }

    public function resolveRecord(): ?Article
    {
        return Article::firstOrNew([
             'code_article' => $this->data['code_article'], // Match on unique field
        ]);
    }


    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your articles import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
