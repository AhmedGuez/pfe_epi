<?php

namespace App\Filament\Clusters\Paie\Resources;

use App\Filament\Clusters\Employee\Resources\PointageResource\Pages\MarkAttendance;
use App\Filament\Clusters\Paie;
use App\Filament\Clusters\Paie\Resources\PointageResource\Pages;
use App\Filament\Clusters\Paie\Resources\PointageResource\RelationManagers;
use App\Models\Pointage;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PointageResource extends Resource
{
   

    protected static ?string $cluster = Paie::class;

    protected static ?string $model = Pointage::class;

    protected static ?string $navigationIcon = 'heroicon-o-finger-print';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('employee_id')
                    ->relationship('employee', 'full_name')
                    ->label('Employee')
                    ->required(),
                DatePicker::make('date')
                    ->label('Date')
                    ->required(),
                TextInput::make('hours_worked')
                    ->label('Hours Worked')
                    ->required()
                    ->numeric(),
                TextInput::make('overtime_hours')
                    ->label('Overtime Hours')
                    ->numeric(),
                Toggle::make('is_weekend')
                    ->label('Worked on Weekend'),
            ]);
    }
    

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.full_name')->label('Employee')->searchable(),
                TextColumn::make('date')->label('Date')->searchable(),
                TextColumn::make('hours_worked')->label('Hours Worked'),
                TextColumn::make('overtime_hours')->label('Overtime Hours'),
                ToggleColumn::make('is_weekend')->label('Weekend Work'),
            ])
            ->defaultSort('date', 'desc')
            ->filters([
                // Specific Date Filter
                Tables\Filters\Filter::make('date')
                    ->label('Filter by Date')
                    ->form([
                        Forms\Components\DatePicker::make('date')
                            ->label('Select Date')
                            ->required(),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query->when(
                            isset($data['date']),
                            fn($q) => $q->whereDate('date', $data['date'])
                        );
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
            'index' => Pages\ListPointages::route('/'),
            // 'create' => Pages\CreatePointage::route('/create'),
            // 'edit' => Pages\EditPointage::route('/{record}/edit'),
            'mark-attendance' => MarkAttendance::route('/mark-attendance'),
        ];
    }
}
