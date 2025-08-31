<?php

namespace App\Filament\Clusters\Requetes\Resources;

use App\Filament\Clusters\Requetes;
use App\Filament\Clusters\Requetes\Resources\AbsencesResource\Pages;
use App\Filament\Clusters\Requetes\Resources\AbsencesResource\RelationManagers;
use App\Models\Absences;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AbsencesResource extends Resource
{
    protected static ?string $model = Absences::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $cluster = Requetes::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('employe_id')
                    ->relationship('employe', 'full_name') // Adjust to your `Employee` model name field
                    ->required()->searchable()->preload(),
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
                                $set('duree_jours', $endDate->diffInDays($startDate) + 1);
                            } else {
                                $set('duree_jours', 0);
                            }
                        } else {
                            $set('duree_jours', 0);
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
                                $set('duree_jours', $endDate->diffInDays($startDate) + 1);
                            } else {
                                $set('duree_jours', 0);
                            }
                        } else {
                            $set('duree_jours', 0);
                        }
                    }),
    
                TextInput::make('duree_jours')
                    ->label('Durée (Jours)')
                    ->numeric()
                    ->readOnly()
                    ->default(0),
                Forms\Components\Textarea::make('raison')->required(),
                Forms\Components\Select::make('justification')
                    ->options([
                        'Aucune' => 'Aucune',
                        'Certificat' => 'Certificat',
                        'Autre' => 'Autre',
                    ])
                    ->default('Aucune')
                    ->required(),
            ]);
    }


    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('employe.full_name')->label('Employé')->alignCenter()->searchable(),
            Tables\Columns\TextColumn::make('date_debut')->label('Date de Début')->date()->alignCenter()->searchable(),
            Tables\Columns\TextColumn::make('date_fin')->label('Date de Fin')->date()->alignCenter()->searchable(),
            Tables\Columns\TextColumn::make('duree_jours')->label('Durée en Jours')->alignCenter()->searchable(),
            Tables\Columns\TextColumn::make('justification')->label('Justification')->alignCenter()->searchable(),
        ])
        ->filters([
            // Year Filter
            Tables\Filters\Filter::make('year')
                ->label('Filtrer par Année')
                ->form([
                    Forms\Components\Select::make('year')
                        ->label('Année')
                        ->options(function () {
                            $currentYear = now()->year;
                            $years = [];
                            for ($i = $currentYear - 2; $i <= $currentYear + 2; $i++) {
                                $years[$i] = $i;
                            }
                            return $years;
                        })
                        ->default(now()->year)
                        ->required(),
                ])
                ->query(function (Builder $query, array $data) {
                    if (isset($data['year'])) {
                        return $query->where(function ($q) use ($data) {
                            $q->whereYear('date_debut', $data['year'])
                                ->orWhereYear('date_fin', $data['year']);
                        });
                    }
                }),
        
            // Month Filter
            Tables\Filters\Filter::make('month')
                ->label('Filtrer par Mois')
                ->form([
                    Forms\Components\Select::make('month')
                        ->label('Mois')
                        ->options([
                            '1' => 'Janvier',
                            '2' => 'Février',
                            '3' => 'Mars',
                            '4' => 'Avril',
                            '5' => 'Mai',
                            '6' => 'Juin',
                            '7' => 'Juillet',
                            '8' => 'Août',
                            '9' => 'Septembre',
                            '10' => 'Octobre',
                            '11' => 'Novembre',
                            '12' => 'Décembre',
                        ])
                        ->default(now()->month)
                        ->required(),
                ])
                ->query(function (Builder $query, array $data) {
                    if (isset($data['month'])) {
                        return $query->where(function ($q) use ($data) {
                            $q->whereMonth('date_debut', $data['month'])
                                ->orWhereMonth('date_fin', $data['month']);
                        });
                    }
                }),
        ])
        
        ->actions([
            Tables\Actions\EditAction::make()->label(''),
            Tables\Actions\ViewAction::make()->label(''),
            Tables\Actions\DeleteAction::make()->label(''),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                // Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListAbsences::route('/'),
            'create' => Pages\CreateAbsences::route('/create'),
            'edit' => Pages\EditAbsences::route('/{record}/edit'),
        ];
    }
}
