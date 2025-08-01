<?php

namespace App\Filament\Clusters\MatierePremiere\Resources\BncMatierePremierResource\Pages;

use App\Filament\Clusters\MatierePremiere\Resources\BncMatierePremierResource;
use Filament\Actions;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ViewRecord;

class BncMatierePremiereView extends ViewRecord
{
    protected static string $resource = BncMatierePremierResource::class;


    protected function getFormSchema(): array
    {
        return [
            Section::make('Détails de la Commande')->schema([
                TextInput::make('bnc_number')->label('BNC N°')->disabled(),
                TextInput::make('created_by')->label('Créé par')->disabled(),
                DatePicker::make('creation_date')->label('Date de Création')->disabled(),
                TextInput::make('status')
                    ->label('Statut')
                    ->disabled()
                    ->formatStateUsing(fn ($state) => $state ? 'Confirmé' : 'En attente'),
            ]),

            Section::make('Articles Associés')->schema([
                Repeater::make('articles')
                    ->relationship('articles') // Ensure the relationship is defined in the model
                    ->schema([
                        Select::make('categorie_id')
                            ->label('Catégorie')
                            ->relationship('category', 'name')
                            ->disabled(),
                        Select::make('article_matiere_premiere_id')
                            ->label('Nom de l\'Article')
                            ->relationship('articleMatierePremiere', 'name')
                            ->disabled(),
                        TextInput::make('quantity')->label('Quantité')->disabled(),
                        TextInput::make('unite')->label('Unité')->disabled(),
                    ])
                    ->disableAddingRows()
                    ->disableDeletingRows()
                    ->disableSorting(),
            ]),
        ];
    }
}
