<?php

namespace App\Filament\Clusters\Requetes\Resources;

use App\Filament\Clusters\Requetes;
use App\Filament\Clusters\Requetes\Resources\PrimeResource\Pages;
use App\Filament\Clusters\Requetes\Resources\PrimeResource\RelationManagers;
use App\Models\Employees;
use App\Models\Prime;
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

class PrimeResource extends Resource
{
    protected static ?string $model = Prime::class;
    protected static ?string $navigationLabel = "Primes";
    protected static ?string $cluster = Requetes::class;
    protected static ?string $navigationIcon = 'heroicon-o-gift';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Select::make('employee_id')
            ->label('Nom Employee')
            ->options(Employees::all()->pluck('full_name', 'id')->toArray())
            ->searchable()
            ->preload()
            ->required(),


            DatePicker::make('date')
            ->default(now())
            ->label("Date D'avance")
            ->required(),      
           TextInput::make('amount')->label('montant')->placeholder('Mantant')->required(),
           TextInput::make('raison')->label('Raison')->placeholder('Raison')->required(),
        ]);
    }

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('employee.full_name')->label('Nom Employee')->searchable()->sortable()->alignCenter(),
            TextColumn::make('date')->label("Date D'avance")->searchable()->sortable()->alignCenter(),
            TextColumn::make('amount')->label('Montant')->searchable()->sortable()->alignCenter(),
            TextColumn::make('raison')->label('Raison')->searchable()->sortable()->alignCenter(),
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
                        return $query->whereYear('date', $data['year']);
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
                        return $query->whereMonth('date', $data['month']);
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
            'index' => Pages\ListPrimes::route('/'),
            // 'create' => Pages\CreatePrime::route('/create'),
            // 'edit' => Pages\EditPrime::route('/{record}/edit'),
        ];
    }
}
