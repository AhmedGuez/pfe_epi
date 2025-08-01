<?php

namespace App\Filament\Imports;

use App\Models\Pieces;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Filament\Notifications\Notification;

class PiecesImporter extends Importer
{
    protected static ?string $model = Pieces::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('code_piece')
                ->requiredMapping()
                ->rules(['required', 'max:50'])
                ->example('P12345 **'),

            ImportColumn::make('nom_piece')
                ->requiredMapping()
                ->rules(['required', 'max:100'])
                ->example('Brake Pad **'),

            ImportColumn::make('categorie')
                ->requiredMapping()
                ->rules(['required'])
                ->example('Mecanique, Electrique **',),

            ImportColumn::make('quantite')
                ->requiredMapping()
                ->rules(['required', 'numeric', 'min:0'])
                ->example('10 **'),

            ImportColumn::make('seuil_minimum')
                ->requiredMapping()
                ->rules(['required', 'numeric', 'min:0'])
                ->example('5 **'),

            ImportColumn::make('unite_mesure')
                ->rules(['nullable', 'max:20'])
                ->example('piece'),

            ImportColumn::make('marque')
                ->rules(['nullable', 'max:50'])
                ->example('Toyota'),

            ImportColumn::make('model')
                ->rules(['nullable', 'max:50'])
                ->example('Corolla'),

            ImportColumn::make('dimension')
                ->rules(['nullable', 'max:100'])
                ->example('10x5 cm'),

            ImportColumn::make('puissance')
                ->rules(['nullable', 'max:50'])
                ->example('100W'),

            ImportColumn::make('materiau')
                ->rules(['nullable', 'max:50'])
                ->example('Steel'),

            ImportColumn::make('emplacement')
                ->rules(['nullable', 'max:100'])
                ->example('Shelf A3'),

            ImportColumn::make('fournisseur')
                ->rules(['nullable',])
                ->example('Ste Plastique'),

            ImportColumn::make('prix_unitaire')
                ->rules(['nullable', 'numeric', 'min:0'])
                ->example('20.50'),

            ImportColumn::make('prix_total')
                ->rules(['nullable', 'numeric', 'min:0'])
                ->example('205.00'),

            ImportColumn::make('etat')
                ->rules(['nullable'])
                ->example('Neuf, Occasion, Reparer'),

            ImportColumn::make('compatibilite')
                ->rules(['nullable', 'max:255'])
                ->example('Compatible with Model X'),

            ImportColumn::make('date_ajout')
                ->rules(['nullable', 'date'])
                ->example('Attention !! Date Lezem Form Hedhi 2024-12-30'),

            ImportColumn::make('date_derniere_utilisation')
                ->rules(['nullable', 'date'])
                ->example('Attention !! Date Lezem Form Hedhi 2024-12-30'),

            ImportColumn::make('garantie')
                ->rules(['nullable', 'max:50'])
                ->example('2 Years'),

            ImportColumn::make('numero_serie')
                ->rules(['nullable', 'max:100'])
                ->example('SN123456789'),

            ImportColumn::make('description')
                ->rules(['nullable', 'max:255'])
                ->example('This is a high-quality piece.'),
        ];
    }

    public function resolveRecord(): ?Pieces
    {
        try {
            return Pieces::updateOrCreate(
                ['code_piece' => $this->data['code_piece']], // Unique identifier
                [
                    'nom_piece' => $this->data['nom_piece'],
                    'categorie' => $this->data['categorie'],
                    'quantite' => $this->data['quantite'],
                    'seuil_minimum' => $this->data['seuil_minimum'],
                    'unite_mesure' => $this->data['unite_mesure'],
                    'marque' => $this->data['marque'],
                    'model' => $this->data['model'],
                    'dimension' => $this->data['dimension'],
                    'puissance' => $this->data['puissance'],
                    'materiau' => $this->data['materiau'],
                    'emplacement' => $this->data['emplacement'],
                    'fournisseur' => $this->data['fournisseur'],
                    'prix_unitaire' => $this->data['prix_unitaire'],
                    'prix_total' => $this->data['prix_total'],
                    'etat' => $this->data['etat'],
                    'compatibilite' => $this->data['compatibilite'],
                    'date_ajout' => isset($this->data['date_ajout']) ? Carbon::parse($this->data['date_ajout'])->format('Y-m-d') : null,
                    'date_derniere_utilisation' => isset($this->data['date_derniere_utilisation']) ? Carbon::parse($this->data['date_derniere_utilisation'])->format('Y-m-d') : null,
                    'garantie' => $this->data['garantie'],
                    'numero_serie' => $this->data['numero_serie'],
                    'description' => $this->data['description'],
                ]
            );
        } catch (\Exception $e) {
            Log::error('Error importing record: ' . $e->getMessage(), ['data' => $this->data]);

            Notification::make()
                ->title('Import Error')
                ->body('There was an error importing a record: ' . $e->getMessage())
                ->danger()
                ->send();

            return null;
        }
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your pieces import has completed. ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
