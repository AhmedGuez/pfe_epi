<?php

namespace App\Filament\Clusters\BonDeSortie\Resources;

use App\Filament\Clusters\BonDeSortie;
use App\Filament\Clusters\BonDeSortie\Resources\BnsSemiFiniRecapResource\Pages;
use App\Filament\Clusters\BonDeSortie\Resources\BnsSemiFiniRecapResource\RelationManagers;
use App\Models\BnsMargoumSemiFini;
use App\Models\BnsSemiFiniRecap;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BnsSemiFiniRecapResource extends Resource
{
    protected static ?string $model = BnsMargoumSemiFini::class;

    protected static ?string $navigationLabel = "Gestion des Bons de Sortie";

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $cluster = BonDeSortie::class;
    protected static ?int $navigationSort = 1;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('bon_sortie_number')
                    ->label('Bon Sortie Number')
                    ->sortable()
                    ->searchable()
                    ->alignCenter(),
                    
                Tables\Columns\TextColumn::make('usine')
                    ->label('Usine')
                    ->sortable()
                    ->searchable()
                    ->alignCenter(),
                    
                Tables\Columns\TextColumn::make('creation_date')
                    ->label('Creation Date')
                    ->date()
                    ->sortable()
                    ->alignCenter(),
                    
                Tables\Columns\TextColumn::make('created_by')
                    ->label('Created By')
                    ->sortable()
                    ->searchable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('articles_total_rolls')
                ->label('Total Rouleaux')
                ->getStateUsing(function (BnsMargoumSemiFini $record) {
                    return $record->articles ? $record->articles->sum('nombre_de_rouleaux') : 0;
                })->alignCenter(),
    
                Tables\Columns\TextColumn::make('articles_total_pieces')
                ->label('Total Pieces')
                ->getStateUsing(function (BnsMargoumSemiFini $record) {
                    return $record->articles ? $record->articles->sum('nombre_de_pieces_semi_fini') : 0;
                })->alignCenter(),
                
               
                
    
                IconColumn::make('status')
                    ->label('Validation')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->alignCenter()
            ])
            ->filters([
                Tables\Filters\Filter::make('date')
                    ->form([
                        Forms\Components\DatePicker::make('creation_date_from')
                            ->label('From')
                            ->default(Carbon::now()->startOfWeek()), // Default to the start of this week
                        Forms\Components\DatePicker::make('creation_date_to')
                            ->label('To')
                            ->default(Carbon::now()->endOfWeek()), // Default to the end of this week
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['creation_date_from'] ?? null, fn ($query, $date) => $query->where('creation_date', '>=', $date))
                            ->when($data['creation_date_to'] ?? null, fn ($query, $date) => $query->where('creation_date', '<=', $date));
                    }),
            ])
            
            ->actions([
                // Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListBnsSemiFiniRecaps::route('/'),
            'create' => Pages\CreateBnsSemiFiniRecap::route('/create'),
            'edit' => Pages\EditBnsSemiFiniRecap::route('/{record}/edit'),
        ];
    }
}
