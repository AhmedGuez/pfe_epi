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
use Filament\Forms\Components\Section;
use Filament\Tables\Filters\Filter;

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
                Section::make('')->schema([
                    Select::make('employee_id')
                        ->label('Nom Employee')
                        ->options(Employees::all()->pluck('full_name', 'id')->toArray())
                        ->searchable()
                        ->preload()
                        ->required(),
                    TextInput::make('raison')->label('Raison')->required(),
                    TextInput::make('montant')->label('Montant')->numeric()->required(),
                    Select::make('mois')
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
                ])->columns(3)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.full_name')->label('Nom Employee')->searchable()->sortable()->alignCenter(),
                TextColumn::make('raison')->label('Raison')->searchable()->sortable()->alignCenter(),
                TextColumn::make('montant')->label('Montant')->searchable()->sortable()->alignCenter(),
                TextColumn::make('mois')->label('Mois')->searchable()->sortable()->alignCenter(),
            ])
            ->filters([
                Filter::make('mois_filter')
                    ->form([
                        Select::make('mois')
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
                            ->required(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['mois'],
                                fn (Builder $query, $mois): Builder => $query->where('mois', $mois),
                            );
                    })
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
            'create' => Pages\CreatePrime::route('/create'),
            'edit' => Pages\EditPrime::route('/{record}/edit'),
        ];
    }
}
