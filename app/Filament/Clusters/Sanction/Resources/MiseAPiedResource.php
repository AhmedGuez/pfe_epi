<?php

namespace App\Filament\Clusters\Sanction\Resources;

use App\Filament\Clusters\Sanction;
use App\Filament\Clusters\Sanction\Resources\MiseAPiedResource\Pages;
use App\Filament\Clusters\Sanction\Resources\MiseAPiedResource\RelationManagers;
use App\Models\Miseapied;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MiseAPiedResource extends Resource
{
    protected static ?string $model = Miseapied::class;

    protected static ?string $navigationIcon = 'heroicon-o-hand-raised';
    protected static ?int $navigationSort = 2;


    protected static ?string $cluster = Sanction::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('employe_id')
                    ->relationship('employe', 'full_name')
                    ->required(),
                    DatePicker::make('date_debut')
                    ->label('Date Début')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($set, $get) {
                        $dateDebut = $get('date_debut');
                        $dateFin = $get('date_fin');
    
                        if ($dateDebut && $dateFin) {
                            $startDate = Carbon::parse($dateDebut);
                            $endDate = Carbon::parse($dateFin);
    
                            if ($startDate->lte($endDate)) {
                                $set('nombre_jour', $endDate->diffInDays($startDate) + 1);
                            } else {
                                $set('nombre_jour', 0);
                            }
                        } else {
                            $set('nombre_jour', 0);
                        }
                    }),
    
                DatePicker::make('date_fin')
                    ->label('Date Fin')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($set, $get) {
                        $dateDebut = $get('date_debut');
                        $dateFin = $get('date_fin');
    
                        if ($dateDebut && $dateFin) {
                            $startDate = Carbon::parse($dateDebut);
                            $endDate = Carbon::parse($dateFin);
    
                            if ($startDate->lte($endDate)) {
                                $set('nombre_jour', $endDate->diffInDays($startDate) + 1);
                            } else {
                                $set('nombre_jour', 0);
                            }
                        } else {
                            $set('nombre_jour', 0);
                        }
                    }),
    
                TextInput::make('nombre_jour')
                    ->label('Durée (Jours)')
                    ->numeric()
                    ->readOnly()
                    ->default(0),

                TextInput::make('raison')
                    ->label('Raison')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make(name: 'employe.full_name')->label('Nom Employee')->searchable()->sortable()->alignCenter(),
            TextColumn::make('date_debut')->label('Date de début')->sortable()->alignCenter(),
            TextColumn::make('date_fin')->label('Date de fin')->sortable()->alignCenter(),
            TextColumn::make('nombre_jour')->label('Nombre de jours')->sortable()->alignCenter(),
            TextColumn::make('raison')->label('Raison')->limit(10)->alignCenter(),
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
            'index' => Pages\ListMiseAPieds::route('/'),
            'create' => Pages\CreateMiseAPied::route('/create'),
            'edit' => Pages\EditMiseAPied::route('/{record}/edit'),
        ];
    }
}
