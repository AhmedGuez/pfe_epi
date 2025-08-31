<?php

namespace App\Filament\Clusters\MargoumFini\Resources;

use App\Filament\Clusters\ProduitFini;
use App\Filament\Clusters\MargoumFini\Resources\StockAdjustmentResource\Pages;
use App\Filament\Clusters\MargoumFini\Resources\StockAdjustmentResource\RelationManagers;
use App\Models\StockAdjustment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StockAdjustmentResource extends Resource
{
    protected static ?string $model = StockAdjustment::class;

     protected static ?string $navigationIcon = 'heroicon-o-adjustments-vertical';
        protected static ?string $navigationLabel = "Correction de Stock";


    // protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = ProduitFini::class;

   public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('depot_id')
                    ->relationship('depot', 'name')
                    ->required(),

                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'code_article')
                    ->required()
                    ->searchable()
                    ->preload(),
                    
                Forms\Components\TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->minValue(1),
                    
                Forms\Components\Radio::make('type')
                    ->options([
                        'addition' => 'Add Stock',
                        'subtraction' => 'Remove Stock',
                    ])
                    ->required()
                    ->inline(),
                    
                Forms\Components\Textarea::make('reason')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('depot.name'),
                Tables\Columns\TextColumn::make('product.name'),
                Tables\Columns\TextColumn::make('quantity'),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'addition' => 'success',
                        'subtraction' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('user.name'),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
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
            'index' => Pages\ListStockAdjustments::route('/'),
            'create' => Pages\CreateStockAdjustment::route('/create'),
            'edit' => Pages\EditStockAdjustment::route('/{record}/edit'),
        ];
    }
}
