<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FournisseurResource\Pages;
use App\Filament\Resources\FournisseurResource\RelationManagers;
use App\Models\Fournisseur;
use Filament\Forms;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Actions\DirectDeleteAction;

class FournisseurResource extends Resource
{
    protected static ?string $model = Fournisseur::class;
    protected static ?string $navigationGroup = 'Gestion des Achats';

    protected static ?string $navigationLabel = "Fournisseurs";
    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
               TextInput::make('nom_fournisseur')->required(),
               TextInput::make('nom_commercial')->required(),
               TextInput::make('adresse')->required(),
               TextInput::make('produit')->required(),
               TextInput::make('secteur'),
               TextInput::make('adresse_mail')->email(),     
               TagsInput::make('num_tel')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nom_fournisseur')->searchable()->sortable()->alignCenter(),
                TextColumn::make('nom_commercial')->searchable()->sortable()->alignCenter(),
                TextColumn::make('adresse')->searchable()->sortable()->alignCenter(),
                TextColumn::make('produit')->searchable()->sortable()->alignCenter(),
                TextColumn::make('secteur')->searchable()->sortable()->alignCenter(),
                TextColumn::make('adresse_mail')->searchable()->sortable()->alignCenter(),
                TextColumn::make('num_tel')->searchable()->sortable()->alignCenter(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                DirectDeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFournisseurs::route('/'),
            'create' => Pages\CreateFournisseur::route('/create'),
            'view' => Pages\ViewFournisseur::route('/{record}'),
            'edit' => Pages\EditFournisseur::route('/{record}/edit'),
        ];
    }
}
