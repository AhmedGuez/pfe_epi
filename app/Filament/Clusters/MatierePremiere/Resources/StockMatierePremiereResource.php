<?php

namespace App\Filament\Clusters\MatierePremiere\Resources;

use App\Filament\Clusters\MatierePremiere;
use App\Filament\Clusters\MatierePremiere\Resources\StockMatierePremiereResource\Pages;
use App\Filament\Clusters\MatierePremiere\Resources\StockMatierePremiereResource\RelationManagers;
use App\Models\Category;
use App\Models\StockMatierePremiere;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StockMatierePremiereResource extends Resource
{
    protected static ?string $model = StockMatierePremiere::class;

    protected static ?string $navigationLabel = "Stock Actuels";

    protected static ?string $navigationIcon = 'heroicon-o-square-3-stack-3d';

    protected static ?string $cluster = MatierePremiere::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category.name')->searchable()->sortable()->label('Catégories')->alignCenter(),
                TextColumn::make('article.name')->searchable()->sortable()->label('Référance Article')->alignCenter(),
                TextColumn::make('quantity')->searchable()->sortable()->label('Quantité')->alignCenter(),
                TextColumn::make('unite')->searchable()->sortable()->label('unité')->alignCenter(),
            ])->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('categorie_id')
                    ->label('Category')
                    ->options(Category::all()->pluck('name', 'id')->toArray())
            ], layout: FiltersLayout::AboveContent)
            ->filtersFormColumns(3)
            ->actions([
                // Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
                
            ])
            ->headerActions([
               
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
            'index' => Pages\ListStockMatierePremieres::route('/'),
            'create' => Pages\CreateStockMatierePremiere::route('/create'),
            'edit' => Pages\EditStockMatierePremiere::route('/{record}/edit'),
        ];
    }
}
