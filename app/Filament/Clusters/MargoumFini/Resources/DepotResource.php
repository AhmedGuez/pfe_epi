<?php

namespace App\Filament\Clusters\MargoumFini\Resources;

use App\Filament\Clusters\ProduitFini;
use App\Filament\Clusters\MargoumFini\Resources\DepotResource\Pages;
use App\Filament\Clusters\MargoumFini\Resources\DepotResource\RelationManagers;
use App\Models\Depot;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DepotResource extends Resource
{
    protected static ?string $model = Depot::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
    protected static ?string $navigationLabel = "Dépôts";


    protected static ?string $cluster = ProduitFini::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),
                TextInput::make('location'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('location'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListDepots::route('/'),
            // 'create' => Pages\CreateDepot::route('/create'),
            // 'edit' => Pages\EditDepot::route('/{record}/edit'),
        ];
    }
}
