<?php

namespace App\Filament\Clusters\MatierePremiere\Resources;

use App\Filament\Clusters\MatierePremiere;
use App\Filament\Clusters\MatierePremiere\Resources\ArrivageMatierePremiereResource\Pages;
use App\Filament\Clusters\MatierePremiere\Resources\ArrivageMatierePremiereResource\RelationManagers;
use App\Models\ArivageMatierePremiere;
use App\Models\ArrivageMatierePremiere;
use App\Models\ArticleMatierePremiere;
use App\Models\Category;
use App\Models\StockMatierePremiere;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use App\Filament\Actions\DirectDeleteAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ArrivageMatierePremiereResource extends Resource
{
    protected static ?string $model = ArivageMatierePremiere::class;

    protected static ?string $navigationLabel = "Nos Arrivages";
    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $cluster = MatierePremiere::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Date de Création')->schema([
                    DatePicker::make('creation_date')
                        ->default(now())
                        ->label('Date de Création')
                        ->required(),
                    TextInput::make('created_by')
                        ->label('Créé par')
                        ->readOnly()
                        ->live(onBlur:true) 
                        ->placeholder('Automatique!')
                        ->required(),
                ])->columns(2)
                ->afterStateUpdated(function (Get $get, Set $set) {
                    $user = Auth::user()->name;
                    $set('created_by', $user);
                }),
    
                Section::make('Articles')->schema([
                    Repeater::make('articles')
                        ->relationship()
                        ->defaultItems(1)
                        ->columnSpanFull()
                        ->schema([
                            Select::make('categorie_id')
                                ->label('Catégorie')
                                ->options(function () {
                                    return Category::pluck('name', 'id')->all();
                                })
                                ->searchable()
                                ->required()
                                ->reactive(),
    
                            Select::make('article_matiere_premiere_id')
                                ->label('Nom Article')
                                ->options(function (Get $get) {
                                    $selectedCategoryId = $get('categorie_id');
                                    if ($selectedCategoryId) {
                                        return ArticleMatierePremiere::where('categorie_id', $selectedCategoryId)
                                            ->pluck('name', 'id')->toArray();
                                    } else {
                                        return [];
                                    }
                                })
                                ->searchable()
                                ->required()
                                ->reactive(),
    
                            TextInput::make('quantity')
                                ->label('Quantité')
                                ->placeholder('Ajouter la quantité'),
    
                            Select::make('unite')
                                ->label('Unité')
                                ->required()
                                ->options([
                                    'Pièces' => 'Pièces',
                                    'KG' => 'Kg',
                                ]),
                        ])->columns(4),
                ]),
            ]);
    }
    
    

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->searchable()->sortable()->label('Référance arrivage')->alignCenter(),
                TextColumn::make('creation_date')->searchable()->sortable()->label('Date de Création')->alignCenter(),
                TextColumn::make('created_by')->searchable()->sortable()->label('Créé par')->alignCenter(),
                IconColumn::make('status')->label('Confirmation')
                ->boolean()->alignCenter(),
            ])->defaultSort('created_at', 'desc')
            
            ->filters([
                Filter::make('date_filter')
                ->form([
                    DatePicker::make('date')
                        ->label('Date')
                ])
                ->query(function (Builder $query, array $data): Builder {
                    if (! $data['date']) {
                        return $query;
                    }

                    return $query->whereDate('created_at', $data['date']);
            }),
            ], layout: FiltersLayout::AboveContent)->filtersFormColumns(3)

            ->actions([
                Tables\Actions\ViewAction::make()->label(''),
                Tables\Actions\EditAction::make()
                ->label('')
                ->visible(fn ($record) => in_array($record->status, [false, 0, 'false'], true)),

                DirectDeleteAction::make()
                ->label('')
                ->visible(fn ($record) => in_array($record->status, [false, 0, 'false'], true)),
                
                    Action::make('status')
                        ->label('Add To Stock')
                        ->action(function (Model $record) {
                            // Get the articles associated with this arivage
                            $articles = $record->articles;
                
                            foreach ($articles as $article) {
                                // Check if a stock entry with the same code_article and categorie_id exists
                                $existingStock = StockMatierePremiere::where('article_matiere_premiere_id', $article->article_matiere_premiere_id)
                                    ->where('categorie_id', $article->categorie_id)
                                    ->first();
                
                                if ($existingStock) {
                                    // Update the quantity of the existing stock
                                    $existingStock->quantity += $article->quantity;
                                    $existingStock->save();
                                } else {
                                    // Create a new stock entry
                                    StockMatierePremiere::create([
                                        'article_matiere_premiere_id' => $article->article_matiere_premiere_id,
                                        'categorie_id' => $article->categorie_id,
                                        'quantity' => $article->quantity,
                                        'unite' => $article->unite,
                                    ]);
                                }
                            }
                
                            // Update the status of the $record
                            $record->update([
                                'status' => true,
                            ]);
                        })
                        ->requiresConfirmation()
                        ->disabled(fn(Model $record) => $record->status)
                        ->color('success')
                        ->icon('heroicon-m-check-badge'),
                
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                ])

            ->groups([
                Tables\Grouping\Group::make('created_at')
                    ->label('Date')
                    ->date()
                    ->collapsible(),
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
            'index' => Pages\ListArrivageMatierePremieres::route('/'),
            'create' => Pages\CreateArrivageMatierePremiere::route('/create'),
            'edit' => Pages\EditArrivageMatierePremiere::route('/{record}/edit'),
        ];
    }
}
