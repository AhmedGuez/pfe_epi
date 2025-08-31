<?php

namespace App\Filament\Clusters\BonDeSortie\Resources;

use App\Filament\Clusters\BonDeSortie;
use App\Filament\Clusters\BonDeSortie\Resources\BnsMargoumSemiFiniResource\Pages;
use App\Filament\Clusters\BonDeSortie\Resources\BnsMargoumSemiFiniResource\RelationManagers;
use App\Models\Article;
use App\Models\BnsMargoumSemiFini;
use App\Models\BnsMargoumSemiFiniArticles;
use App\Models\Commande;
use App\Models\CommandeArticle;
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

class BnsMargoumSemiFiniResource extends Resource
{
    protected static ?string $model = BnsMargoumSemiFini::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-right-start-on-rectangle';

    protected static ?string $cluster = BonDeSortie::class;
    protected static ?int $navigationSort = 0;


    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make('Commande Client')->schema([
                TextInput::make('bon_sortie_number')
                ->default(function () {
                    $prefix = 'BNS-M-SF-';
                    $lastBonSortie = BnsMargoumSemiFini::where('bon_sortie_number', 'like', $prefix . '%')
                        ->latest('id') // or any timestamp/ID-based column for ordering
                        ->first();
            
                    if ($lastBonSortie && preg_match('/' . preg_quote($prefix, '/') . '(\d+)$/', $lastBonSortie->bon_sortie_number, $matches)) {
                        $lastNumber = (int)$matches[1];
                        $newNumber = $lastNumber + 1;
                    } else {
                        $newNumber = 1; // Default start number
                    }
            
                    return $prefix . str_pad($newNumber,  '0', STR_PAD_LEFT); // Pads with leading zeros
                })
                ->unique(BnsMargoumSemiFini::class, 'bon_sortie_number', ignoreRecord: true)
                ->readOnly()
                ->required(),

                Select::make('usine')
                ->label('Livré à')
                ->required()
                ->default('Usine Tapis')
                ->options([
                    'Usine Tapis' => 'Usine Tapis',
                ]),

                DatePicker::make('creation_date')
                    ->default(now())
                    ->label('Date de Création')
                    ->required(),
        
                TextInput::make('created_by')
                    ->label('Créé par')
                    ->placeholder('Automatique!')
                    ->readOnly()
                    ->live(onBlur:true)
                    ->required(),

              

            ])->columns(4)
                ->afterStateUpdated(function (Get $get, Set $set) {
                $User = Auth::user()->name;
                $set('created_by', $User);
            }),
       
        
            Repeater::make('bnsMargoumSemiFiniArticles')
                ->label('Selectionner les Articles')
                ->relationship()
                ->defaultItems(1)
                ->columnSpanFull()
                ->live()
                ->schema([

                    Select::make('commande_id')
                        ->label('Code Commande')
                        ->options(function () {
                            $options = Commande::all()->pluck('code_commande', 'id')->toArray();
                            $options[null] = 'No Commande'; // Adding "No Commande" as an option
                            return $options;
                        })
                        ->searchable()
                        ->reactive()
                        ->afterStateUpdated(function (Set $set, Get $get, $state) {
                            if (is_null($state)) { // If "No Commande" is selected
                                $set('article_id', null); // Clear the selected article
                                $set('article_options', Article::all()->pluck('code_article', 'id')->toArray());
                            } else {
                                // Fetch articles related to the selected commande
                                $articles = CommandeArticle::query()
                                    ->where('commande_id', $state)
                                    ->with('article') // Ensure the article relationship is loaded
                                    ->get()
                                    ->pluck('article.code_article', 'article.id') // Map article.id to article.code_article
                                    ->toArray();
                        
                                $set('article_options', $articles); // Update the options dynamically
                            }
                        }),

        
                        Select::make('article_id')
                        ->label('Article')
                        ->searchable()
                        ->live()
                        ->required()
                        ->reactive()
                        ->options(function ($get) {
                            // Dynamically get the options, for example, from an updated source
                            return $get('article_options') ?? Article::pluck('code_article', 'id')->toArray();
                        }),                    
                
                    
                    TextInput::make('nombre_de_rouleaux')
                        ->label('Nombre de Rouleaux')
                        ->numeric()
                        ->required()
                        ->minValue(1),    

                    TextInput::make('nombre_de_pieces_semi_fini')
                        ->label('Nombre Total de Piéces')
                        ->numeric()
                        ->required()
                        ->minValue(1),
                        
                ])
                ->columns(4), 
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

            Filter::make('commande_filter')
                    ->form([
                        Select::make('commande_id')
                            ->label('Code Commande')
                            ->options(Commande::all()->pluck('code_commande', 'id')->toArray())
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (! $data['commande_id']) {
                            return $query;
                        }
                        return $query->whereHas('bnsMargoumSemiFiniArticles', function (Builder $query) use ($data) {
                            $query->where('commande_id', $data['commande_id']);
                        });
                    }),
                



            ], layout: FiltersLayout::AboveContentCollapsible)->filtersFormColumns(3)
            
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
                        // Find the margoum_fini_article records
                        $BnsMargoumArticles = BnsMargoumSemiFiniArticles::where('bns_margoum_semi_fini_id', $record->id)->get();
            
                        foreach ($BnsMargoumArticles as $BnsMargoumArticle) {
                            // Get the commande record
                            $commande = Commande::find($BnsMargoumArticle->commande_id); 
            
                            if ($commande) {
                                // Find the corresponding commande_article
                                $commandeArticle = CommandeArticle::where('commande_id', $commande->id)
                                    ->where('article_id', $BnsMargoumArticle->article_id)
                                    ->first();
            
                                if ($commandeArticle) {
                                    // Calculate the new semi-finished pieces
                                    $new_semi_fini = $commandeArticle->nombre_de_pieces_semi_fini + $BnsMargoumArticle->nombre_de_pieces_semi_fini;
            
                                    // Update the semi-finished pieces and calculate rest if needed
                                    if ($new_semi_fini > $commandeArticle->nombre_de_pieces) {
                                        $rest = $new_semi_fini - $commandeArticle->nombre_de_pieces;
                                        $commandeArticle->update([
                                            'nombre_de_pieces_semi_fini' => $new_semi_fini,
                                            'rest' => $commandeArticle->rest + $rest,
                                        ]);
                                    } else {
                                        $commandeArticle->update([
                                            'nombre_de_pieces_semi_fini' => $new_semi_fini,
                                        ]);
                                    }
                                }
                            }
                        }
                        // Update the status of the record
                        $record->update([
                            'status' => true,
                        ]);
                    })
                    ->requiresConfirmation()
                    ->disabled(fn(Model $record) => $record->status)
                    ->color('success')
                    ->icon('heroicon-m-check-badge'),
            
                Action::make('Print')->label('')
                    ->icon('heroicon-o-printer')
                    ->url(fn(BnsMargoumSemiFini $record) => route('bnsMargoumSf.pdf.download', $record))
                    ->openUrlInNewTab()
                    ->visible(fn ($record) => in_array($record->status, [true, 1, 'true'], true)),
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
            'index' => Pages\ListBnsMargoumSemiFinis::route('/'),
            'create' => Pages\CreateBnsMargoumSemiFini::route('/create'),
            'edit' => Pages\EditBnsMargoumSemiFini::route('/{record}/edit'),
        ];
    }
}
