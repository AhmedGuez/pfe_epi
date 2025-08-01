<?php

namespace App\Filament\Resources;

use App\Enums\DemandeAchatStatus;
use App\Filament\Resources\DemandeAchatsResource\Pages;
use App\Filament\Resources\DemandeAchatsResource\RelationManagers;
use App\Models\DemandeAchat;
use App\Models\DemandeAchats;
use App\Models\Fournisseur;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Actions\Action;


class DemandeAchatsResource extends Resource
{
    protected static ?string $model = DemandeAchat::class;

    protected static ?string $navigationGroup = 'Gestion des Achats';

    protected static ?string $navigationLabel = "Demande d'Achats";
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('')->schema([

                    DatePicker::make('date_demande')
                        ->default(now())
                        ->label('Date de Demande')
                        ->required()
                        ->columnSpan(2),
                        
                    TextInput::make('created_by')
                        ->label('Créé par')
                        ->placeholder('Automatique!')
                        ->readOnly()
                        ->live(onBlur:true)
                        ->required(),

                        Select::make('fournisseur_id')
                        ->label('Fournisseur')
                        ->options(function () {
                            return \App\Models\Fournisseur::pluck('nom_fournisseur', 'id')->toArray();
                        })
                        ->searchable()
                        ->required()
                        ->placeholder('Sélectionnez un fournisseur'),

                        TextInput::make('reason')->label("Raison d'Achat")->required()->columnSpan(2)->placeholder("Raison d'achat"), 
                        
                        ToggleButtons::make('status')
                        ->inline()
                        ->options(DemandeAchatStatus::class)
                        ->default('en cours')
                        ->required(),
                        
                        
    
                ])->columns(3)
                    ->afterStateUpdated(function (Get $get, Set $set) {
                    $User = Auth::user()->name;
                    $set('created_by', $User);
                }),




                Section::make('')->schema([
                    
                   
                    TextInput::make('designation')->label('Designation')->required()->placeholder('Ajouter une Designation'),
                    TextInput::make('ref')->label('Référance')->required()->placeholder('Ajouter une Référance'),    
                    TextInput::make('model')->label('Model')->required()->placeholder('Ajouter le Model Demander'),    
                    TextInput::make('type')->label('Type')->required()->placeholder('Ajouter le Type de Model'),    
                    TextInput::make('quantite')->label('Quantité')->required()->numeric()->placeholder('Quantité Demander')->columnSpan(2),
                    SpatieMediaLibraryFileUpload::make('file_name')->columnSpan(1)->label('Fichier Joint')->columnSpanFull(),       
                ])->columns(3),
                

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('date_demande')->searchable()->sortable()->alignCenter(),
                TextColumn::make('created_by')->searchable()->sortable()->alignCenter(),
                TextColumn::make('designation')->searchable()->sortable()->alignCenter(),
                TextColumn::make('quantite')->searchable()->sortable()->alignCenter(),
                TextColumn::make('status')->searchable()->sortable()->alignCenter(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListDemandeAchats::route('/'),
            'create' => Pages\CreateDemandeAchats::route('/create'),
            'view' => Pages\ViewDemandeAchats::route('/{record}'),
            'edit' => Pages\EditDemandeAchats::route('/{record}/edit'),
        ];
    }
}
