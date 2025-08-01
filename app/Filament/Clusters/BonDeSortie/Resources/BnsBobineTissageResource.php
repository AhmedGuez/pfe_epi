<?php

namespace App\Filament\Clusters\BonDeSortie\Resources;

use App\Filament\Clusters\BonDeSortie;
use App\Filament\Clusters\BonDeSortie\Resources\BnsBobineTissageResource\Pages;
use App\Filament\Clusters\BonDeSortie\Resources\BnsBobineTissageResource\RelationManagers;
use App\Models\ArticleMatierePremiere;
use App\Models\BnsBobineTissage;
use App\Models\BonSortieBobineSr;
use App\Models\Category;
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

class BnsBobineTissageResource extends Resource
{
    protected static ?string $model = BonSortieBobineSr::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-uturn-right';

    protected static ?string $navigationLabel = "Bon Sortie Bobine Surfilage";

    protected static ?int $navigationSort = 3;

    protected static ?string $cluster = BonDeSortie::class;

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make('Date de Création')->schema([

                TextInput::make('bon_sortie_number')
                ->default(function () {
                    $prefix = 'BNS-SR-';
                    $lastBonSortie = BonSortieBobineSr::where('bon_sortie_number', 'like', $prefix . '%')
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
                ->unique(BonSortieBobineSr::class, 'bon_sortie_number', ignoreRecord: true)
                ->readOnly()
                ->required(),

                Select::make('usine')
                ->label('Livré à')
                ->required()
                ->default('Usine Tapis')
                ->options([
                    'Usine Tapis' => 'Usine Tapis',
                    'Usine Margoum' => 'Usine Margoum',
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

                Repeater::make('bonSortieBobineSrArticle')
                ->label('Bobines Surfilage')
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
                    ->reactive(),
                
                TextInput::make('quantity')
                    ->numeric()
                    ->label('Quantité en KG')
                    ->required(),

                ])->columns(3)

                
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('creation_date')->searchable()->sortable()->label('Date de Création')->alignCenter(),
                TextColumn::make('bon_sortie_number')->searchable()->sortable()->label('Numéro BNS Surfilage')->alignCenter(),
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
                ->url(fn(BonSortieBobineSr $record) => route('bonSortieBobineSr.pdf.download', $record))
                ->openUrlInNewTab()
                ->visible(fn ($record) => in_array($record->status, [true, 1, 'true'], true)),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListBnsBobineTissages::route('/'),
            // 'create' => Pages\CreateBnsBobineTissage::route('/create'),
            // 'edit' => Pages\EditBnsBobineTissage::route('/{record}/edit'),
        ];
    }
}
