<?php

namespace App\Filament\Clusters\MatierePremiere\Resources;

use App\Filament\Clusters\MatierePremiere;
use App\Filament\Clusters\MatierePremiere\Resources\BnsMatierePremiereResource\Pages;
use App\Filament\Clusters\MatierePremiere\Resources\BnsMatierePremiereResource\RelationManagers;
use App\Models\ArticleMatierePremiere;
use App\Models\BnsMatierePremiere;
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

class BnsMatierePremiereResource extends Resource
{
    protected static ?string $model = BnsMatierePremiere::class;
    protected static ?string $cluster = MatierePremiere::class;


    protected static ?string $navigationLabel = "Bon de Sortie";
    protected static ?string $navigationIcon = 'heroicon-o-arrow-right-start-on-rectangle';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make('Date de Création')->schema([

                TextInput::make('bon_sortie_number')
                ->default(function () {
                    $prefix = 'BNS-MP-';
                    $lastBonSortie = BnsMatierePremiere::where('bon_sortie_number', 'like', $prefix . '%')
                        ->latest('id')
                        ->first();
            
                    if ($lastBonSortie && preg_match('/' . preg_quote($prefix, '/') . '(\d+)$/', $lastBonSortie->bon_sortie_number, $matches)) {
                        $lastNumber = (int)$matches[1];
                        $newNumber = $lastNumber + 1;
                    } else {
                        $newNumber = 1; // Default start number
                    }
            
                    return $prefix . str_pad($newNumber,  '0', STR_PAD_LEFT); // Pads with leading zeros
                })
                ->unique(BnsMatierePremiere::class, 'bon_sortie_number', ignoreRecord: true)
                ->readOnly()
                ->required(),

                Select::make('usine')
                ->label('Livré à')
                ->required()
                ->default('Usine de Finition')
                ->options([
                    'Usine de Finition' => 'Usine de Finition',
                    'Usine Semi Fini' => 'Usine Semi Fini',
                ]),

                DatePicker::make('creation_date')
                    ->default(now())
                    ->label('Date de Création')
                    ->required(),
        
                TextInput::make('created_by')
                    ->label('Créé par')
                    ->readOnly()
                    ->live(onBlur:true)
                    ->required(),

            ])->columns(4)
                ->afterStateUpdated(function (Get $get, Set $set) {
                $User = Auth::user()->name;
                $set('created_by', $User);
            }),

                Repeater::make('articles')
                ->label('Article')
                ->relationship()
                ->defaultItems(1)
                ->columnSpanFull()
                ->live()
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
                        ->label('Référance Article')
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
                        ->reactive()
                        ->afterStateUpdated(function (Get $get, Set $set) {
                            $selectedArticle = $get('article_matiere_premiere_id');
                            $selectedCategorie = $get('categorie_id');
                            $selectedStock = StockMatierePremiere::where('article_matiere_premiere_id', $selectedArticle)
                                ->where('categorie_id', $selectedCategorie) // Add condition to verify the category
                                ->first();
                            if ($selectedStock) {
                                $set('qty', $selectedStock->quantity);
                                $set('unite', $selectedStock->unite);
                            }
                        })
                        ->columnSpan(2),

                    TextInput::make('unite')
                        ->label('Unité')
                        ->live(onBlur:true)
                        ->readOnly()
                        ->required()->columnSpan(1),
                    
                    TextInput::make('qty')
                        ->label('Quantité en Stock !!')
                        ->live()
                        ->hiddenOn('view')
                        ->disabled()->columnSpan(2),

                    
                    TextInput::make('quantity')
                    ->label('Quantité')
                    ->placeholder('ajouter la quantité')
                    ->numeric()
                    ->maxValue(fn(Get $get) => $get('qty'))
                    ->live(onBlur:true)
                    ->columnSpan(2),
                        


                ])->columns(4),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('creation_date')->searchable()->sortable()->label('Date de Création')->alignCenter(),
                TextColumn::make('bon_sortie_number')->searchable()->sortable()->label('Numéro BNS')->alignCenter(),
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

            // SelectFilter::make('categorie_id')
            // ->label('Categorie')
            // ->relationship('articles.categorie', 'name') 
            // ->preload()
            // ->searchable(),

            Filter::make('category_filter')
                ->form([
                    Select::make('categorie_id')
                        ->label('Categorie')
                        ->options(Category::all()->pluck('name', 'id')->toArray())
                ])
                ->query(function (Builder $query, array $data): Builder {
                    if (! $data['categorie_id']) {
                        return $query;
                    }

                    // Assuming there's a relationship between BnsMatierePremiere and BnsMatierePremiereArticle
                    return $query->whereHas('articles', function (Builder $query) use ($data) {
                        $query->where('categorie_id', $data['categorie_id']);
                    });
                }),

            ], layout: FiltersLayout::AboveContent)->filtersFormColumns(3)
            
            ->actions([
                Tables\Actions\ViewAction::make()->label(''),
                Tables\Actions\EditAction::make()
                ->label('')
                ->visible(fn ($record) => in_array($record->status, [false, 0, 'false'], true)),

                Tables\Actions\DeleteAction::make()
                ->label('')
                ->visible(fn ($record) => in_array($record->status, [false, 0, 'false'], true)),
                

                Action::make('status')
                ->label('')
                ->action(function (Model $record) {
                    // Get the articles associated with this bon sortie
                    $articles = $record->articles;
            
                    foreach ($articles as $article) {
                        // Find the corresponding stock entry
                        $stock = StockMatierePremiere::where('article_matiere_premiere_id', $article->article_matiere_premiere_id)
                            ->where('categorie_id', $article->categorie_id)
                            ->first();
            
                        if ($stock) {
                            // Subtract the quantity of the article from the stock
                            $stock->quantity -= $article->quantity;
            
                            // Prevent stock from going negative
                            if ($stock->quantity < 0) {
                                // Handle negative stock here if needed
                            }
            
                            $stock->save();
                        } else {
                            // Handle case where stock entry is not found if needed
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

                Action::make('Imprimer bonSortie')->label('')
                ->icon('heroicon-o-printer')
                ->visible(fn ($record) => in_array($record->status, [true, 1, 'true'], true))
                ->url(fn(BnsMatierePremiere $record) => route('bonSortie.pdf.download', $record))
                ->openUrlInNewTab()
            
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
            'index' => Pages\ListBnsMatierePremieres::route('/'),
            // 'create' => Pages\CreateBnsMatierePremiere::route('/create'),
            // 'edit' => Pages\EditBnsMatierePremiere::route('/{record}/edit'),
        ];
    }
}
