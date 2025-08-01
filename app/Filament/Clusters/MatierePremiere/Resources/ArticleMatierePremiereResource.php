<?php

namespace App\Filament\Clusters\MatierePremiere\Resources;

use App\Filament\Clusters\MatierePremiere;
use App\Filament\Clusters\MatierePremiere\Resources\ArticleMatierePremiereResource\Pages;
use App\Filament\Clusters\MatierePremiere\Resources\ArticleMatierePremiereResource\RelationManagers;
use App\Models\ArticleMatierePremiere;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ArticleMatierePremiereResource extends Resource
{
    protected static ?string $model = ArticleMatierePremiere::class;

    protected static ?string $navigationLabel = "Nos Articles";
    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    protected static ?string $cluster = MatierePremiere::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                ->rules('required|max:255|min:3')
                ->required()
                ->placeholder('name'),

                Select::make('categorie_id')
                ->label('Category')
                ->options(Category::all()->pluck('name', 'id'))
                ->searchable()
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable()->searchable()->alignCenter(),
                TextColumn::make('category.name')->label('Parent Category')
                ->sortable()
                ->alignCenter()
                ->searchable(),
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
                    // Tables\Actions\DeleteBulkAction::make(),
                    // ExportBulkAction::make()
                    // ->exports([
                    //     ExcelExport::make()
                    //         ->fromTable()
                    //         ->withColumns([
                    //             Column::make('code_article')->heading('Code Article'),
                    //         ])
                            // ->modifyQueryUsing(function ($query) {
                            //     return $query->with('suiviStockRebobinageArticle');
                            // })
                            // ->withFilename('suiviStockRebobinage_export_' . date('Y-m-d')),
                //     ]),
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
            'index' => Pages\ListArticleMatierePremieres::route('/'),
            // 'create' => Pages\CreateArticleMatierePremiere::route('/create'),
            // 'edit' => Pages\EditArticleMatierePremiere::route('/{record}/edit'),
        ];
    }
}
