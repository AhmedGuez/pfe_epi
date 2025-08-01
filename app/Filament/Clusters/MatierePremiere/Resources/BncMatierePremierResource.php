<?php

namespace App\Filament\Clusters\MatierePremiere\Resources;

use App\Filament\Clusters\MatierePremiere;
use App\Filament\Clusters\MatierePremiere\Resources\BncMatierePremierResource\Pages;
use App\Filament\Clusters\MatierePremiere\Resources\BncMatierePremierResource\RelationManagers;
use App\Models\ArticleMatierePremiere;
use App\Models\BncMatierePremier;
use App\Models\BncMatierePremiere;
use App\Models\Category;
use App\Models\StockMatierePremiere;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class BncMatierePremierResource extends Resource
{
    protected static ?string $model = BncMatierePremiere::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationLabel = "Bon de Commande";


    protected static ?string $cluster = MatierePremiere::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Date de Création')->schema([
                    TextInput::make('bnc_number')
                    ->default(function () {
                        $prefix = 'BNC-N°-';
                        $lastBnc = BncMatierePremiere::where('bnc_number', 'like', $prefix . '%')
                            ->latest('id')
                            ->first();
                
                        if ($lastBnc && preg_match('/' . preg_quote($prefix, '/') . '(\d+)$/', $lastBnc->bnc_number, $matches)) {
                            $lastNumber = (int)$matches[1];
                            $newNumber = $lastNumber + 1;
                        } else {
                            $newNumber = 1; // Default start number
                        }
                
                        return $prefix . str_pad($newNumber,  '0', STR_PAD_LEFT); // Pads with leading zeros
                    })
                    ->unique(BncMatierePremiere::class, 'bnc_number', ignoreRecord: true)
                    ->readOnly()
                    ->label('BNC-N°')
                    ->required(),

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


                    Select::make('fournisseur_id')
                    ->label('Fournisseur')
                    ->options(function () {
                        return \App\Models\Fournisseur::pluck('nom_fournisseur', 'id')->toArray();
                    })
                    ->searchable()
                    ->required()
                    ->placeholder('Sélectionnez un fournisseur'),
                ])->columns(3)
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
                                ->reactive()
                                ->afterStateUpdated(function (Get $get, Set $set) {
                                    $selectedArticle = $get('article_matiere_premiere_id');
                                    $selectedCategorie = $get('categorie_id');
                            
                                    // Query the stock with both article and category
                                    $selectedStock = StockMatierePremiere::where('article_matiere_premiere_id', $selectedArticle)
                                        ->where('categorie_id', $selectedCategorie)
                                        ->first();
                            
                                    if ($selectedStock) {
                                        $set('unite', $selectedStock->unite); // Set 'unite' field
                                    }
                                }),
                
    
                            TextInput::make('quantity')
                                ->label('Quantité')
                                ->placeholder('Ajouter la quantité'),
    
                            TextInput::make('unite')
                                ->label('Unité')
                                ->disabled()
                                ->readOnly()
                                
                        ])->columns(2),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('bnc_number')->searchable()->sortable()->label('BNC-N°')->alignCenter(),
            TextColumn::make('creation_date')->searchable()->sortable()->label('Date de Création')->alignCenter(),
            TextColumn::make('created_by')->searchable()->sortable()->label('Créé par')->alignCenter(),
            IconColumn::make('status')->label('Confirmation')
            ->boolean()->alignCenter(),
        ])->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label(''),
                Tables\Actions\EditAction::make()
                    ->label('')
                    ->visible(fn ($record) => in_array($record->status, [false, 0, 'false'], true)),
            
                Tables\Actions\DeleteAction::make()
                    ->label('')
                    ->visible(fn ($record) => in_array($record->status, [false, 0, 'false'], true)),
                    
                    Action::make('status')
                    ->label('Confirmer et Notifier')
                    ->action(function (Model $record) {
                
                        // Update status
                        $record->update([
                            'status' => true,
                        ]);
                
                        // Notify users with the role 'Responsable Magasin'
                        $users = User::whereHas('roles', function ($query) {
                            $query->where('name', 'Responsable Magasin');
                        })->get();
                
                        foreach ($users as $user) {
                            Notification::make()
                            ->title('Commande Confirmée')
                            ->body("
                                La commande n°{$record->bnc_number} a été confirmée.<br>
                                Créée par: {$record->created_by}.
                            ")
                            ->actions([
                                \Filament\Notifications\Actions\Action::make('Voir la Commande')
                                    ->url(route('filament.admin.matiere-premiere.resources.bnc-matiere-premiers.view', ['record' => $record->id]))
                                    ->openUrlInNewTab()
                                    ->button(),
                            ])
                            ->success()
                            ->sendToDatabase($user);
                        
                        
                        }
                    })
                    ->requiresConfirmation()
                    ->disabled(fn (Model $record) => $record->status)
                    ->color('success')
                    ->icon('heroicon-m-check-badge')
                ,
                
                    
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
            'index' => Pages\ListBncMatierePremiers::route('/'),
            'view' => Pages\BncMatierePremiereView::route('/{record}'),
            // 'create' => Pages\CreateBncMatierePremier::route('/create'),
            // 'edit' => Pages\EditBncMatierePremier::route('/{record}/edit'),
        ];
    }
}
