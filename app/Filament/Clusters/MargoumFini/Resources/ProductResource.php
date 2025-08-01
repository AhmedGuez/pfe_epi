<?php

namespace App\Filament\Clusters\MargoumFini\Resources;

use App\Filament\Clusters\ProduitFini;
use App\Filament\Clusters\MargoumFini\Resources\ProductResource\Pages;
use App\Filament\Clusters\MargoumFini\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    // protected static ?string $navigationGroup = 'Margoum Packages';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = "Catalogue Produits";


    protected static ?string $navigationIcon = 'heroicon-o-table-cells';

    protected static ?string $cluster = ProduitFini::class;

  public static function form(Form $form): Form
{
    return $form->schema([
        TextInput::make('code_article')
                ->label('Code Article')
                ->required()
                ->unique(ignoreRecord: true)
                ->live(onBlur: true) // Live updates on blur
                ->afterStateUpdated(function (Get $get, Set $set) {
                    $code = $get('code_article');

                    // Try to get the last segment after slash as color
                    $segments = explode('/', $code);
                    $possibleColor = strtoupper(trim(end($segments)));

                    // Optional: check if it's a known color or just set it directly
                    if (!empty($possibleColor)) {
                        $set('color', $possibleColor);
                    }
                }),

        Section::make('Taille')->schema([
            TextInput::make('largeur')
                ->numeric()
                ->required()
                ->live(onBlur: true),

            TextInput::make('hauteur')
                ->label('Hauteur')
                ->numeric()
                ->required()
                ->live(onBlur: true),

            TextInput::make('coefficient_metrage')
                ->readonly()
                ->live(onBlur: true),

            TextInput::make('prix') // ← moved here
                ->label('Prix')
                ->readonly(), // ← make it readonly
        ])
        ->columns(4) // ← updated to fit 4 fields
        ->afterStateUpdated(function (Get $get, Set $set) {
            $largeur = floatval($get('largeur'));
            $hauteur = floatval($get('hauteur'));

            if ($largeur > 0 && $hauteur > 0) {
                $coefficient_metrage = $largeur * $hauteur;
                $prix = $coefficient_metrage * 5.133;

                $set('coefficient_metrage', $coefficient_metrage);
                $set('prix', number_format($prix, 3, '.', ''));
            }
        }),

        TextInput::make('color')
            ->label('Couleur')
            ->live(onBlur: true)
            ->readonly()
            ->required(),

        TextInput::make('quality')
            ->label('Qualité')
            ->default('Premier Choix')
            ->required(),
    ]);
}
   

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
           TextColumn::make('code_article')->label('Code Article')->alignCenter()->searchable(),
            TextColumn::make('largeur')->label('Largeur')->alignCenter(),
            TextColumn::make('hauteur')->label('Hauteur')->alignCenter(),
            TextColumn::make('coefficient_metrage')->label('Coef. Métrage')->alignCenter(),
            TextColumn::make('color')->label('Couleur')->alignCenter()->searchable(),
            TextColumn::make('quality')->label('Qualité')->alignCenter()->searchable(),
            TextColumn::make('prix')->label('Prix')->alignCenter(),
        ])->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label(''),
                Tables\Actions\EditAction::make()->label(''),
                Tables\Actions\DeleteAction::make()->label(''),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListProducts::route('/'),
            // 'create' => Pages\CreateProduct::route('/create'),
            // 'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }    
}
