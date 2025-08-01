<?php

namespace App\Filament\Clusters\Paie\Resources;

use App\Filament\Clusters\Paie;
use App\Filament\Clusters\Paie\Resources\SalaryResource\Pages;
use App\Filament\Clusters\Paie\Resources\SalaryResource\RelationManagers;
use App\Models\Advance;
use App\Models\Employees;
use App\Models\Pointage;
use App\Models\Prime;
use App\Models\Salary;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SalaryResource extends Resource
{
   
    protected static ?string $cluster = Paie::class;

    protected static ?string $model = Employees::class;

    protected static ?string $navigationIcon = 'heroicon-o-calculator';

    protected static ?string $navigationLabel = 'Salaries';


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
                // Employee Name Column
                TextColumn::make('full_name')
                    ->searchable(isIndividual: true, isGlobal: false)
                    ->label('Employee Name')
                    ->sortable(),
    
                // Total Worked Hours Column
                TextColumn::make('total_hours_worked')
                    ->label('Total Hours Worked')
                    ->getStateUsing(function (Employees $record) {
                        $month = request()->get('month_filter', now()->month);
                        $year = request()->get('year_filter', now()->year);
    
                        return Pointage::where('employee_id', $record->id)
                            ->whereMonth('date', $month)
                            ->whereYear('date', $year)
                            ->sum('hours_worked');
                    }),
    
                // Total Overtime Hours Column
                TextColumn::make('total_overtime_hours')
                    ->label('Overtime Hours')
                    ->getStateUsing(function (Employees $record) {
                        $month = request()->get('month_filter', now()->month);
                        $year = request()->get('year_filter', now()->year);
    
                        return Pointage::where('employee_id', $record->id)
                            ->whereMonth('date', $month)
                            ->whereYear('date', $year)
                            ->sum('overtime_hours');
                    }),
    
                // Total Weekend Hours Column
                TextColumn::make('total_weekend_hours')
                    ->label('Weekend Hours')
                    ->getStateUsing(function (Employees $record) {
                        $month = request()->get('month_filter', now()->month);
                        $year = request()->get('year_filter', now()->year);
    
                        return Pointage::where('employee_id', $record->id)
                            ->whereMonth('date', $month)
                            ->whereYear('date', $year)
                            ->where('is_weekend', true)
                            ->sum('hours_worked');
                    }),
    
                // Total Advances Column
                TextColumn::make('total_advances')
                    ->label('Total Advances')
                    ->getStateUsing(function (Employees $record) {
                        $month = request()->get('month_filter', now()->month);
                        $year = request()->get('year_filter', now()->year);
    
                        return Advance::where('employee_id', $record->id)
                            ->whereMonth('date', $month)
                            ->whereYear('date', $year)
                            ->sum('amount');
                    }),
    
                // Total Primes Column
                TextColumn::make('total_primes')
                    ->label('Total Primes')
                    ->getStateUsing(function (Employees $record) {
                        $month = request()->get('month_filter', now()->month);
                        $year = request()->get('year_filter', now()->year);
    
                        return Prime::where('employee_id', $record->id)
                            ->whereMonth('date', $month)
                            ->whereYear('date', $year)
                            ->sum('amount');
                    }),
    
                // Updated Monthly Salary Column
                TextColumn::make('monthly_salary')
                    ->label('Monthly Salary (Net)')
                    ->getStateUsing(function (Employees $record) {
                        $month = request()->get('month_filter', now()->month);
                        $year = request()->get('year_filter', now()->year);
    
                        $pointages = Pointage::where('employee_id', $record->id)
                            ->whereMonth('date', $month)
                            ->whereYear('date', $year)
                            ->get();
    
                        $hourlyRate = $record->prix_heure;
    
                        $regularHours = $pointages->where('is_weekend', false)->sum('hours_worked');
                        $weekendHours = $pointages->where('is_weekend', true)->sum('hours_worked');
                        $overtimeHours = $pointages->sum('overtime_hours');
    
                        $grossSalary = ($regularHours * $hourlyRate) +
                                    ($weekendHours * $hourlyRate * 2) +
                                    ($overtimeHours * $hourlyRate); // Same rate as regular hours
    
                        $totalAdvances = Advance::where('employee_id', $record->id)
                            ->whereMonth('date', $month)
                            ->whereYear('date', $year)
                            ->sum('amount');
    
                        $totalPrimes = Prime::where('employee_id', $record->id)
                            ->whereMonth('date', $month)
                            ->whereYear('date', $year)
                            ->sum('amount');
    
                        // Net Salary = Gross Salary - Advances + Primes
                        return number_format($grossSalary - $totalAdvances + $totalPrimes, 3);
                    }),
            ])
            ->filters([
                Filter::make('date')
                    ->label('Date Filter')
                    ->form([
                        Select::make('year')
                            ->label('Select Year')
                            ->options(function () {
                                $currentYear = now()->year;
                                $years = [];
                                for ($i = $currentYear - 1; $i <= $currentYear + 1; $i++) {
                                    $years[$i] = $i;
                                }
                                return $years;
                            })
                            ->default(now()->year)
                            ->required(),
    
                        Select::make('month')
                            ->label('Select Month')
                            ->options([
                                '1' => 'January',
                                '2' => 'February',
                                '3' => 'March',
                                '4' => 'April',
                                '5' => 'May',
                                '6' => 'June',
                                '7' => 'July',
                                '8' => 'August',
                                '9' => 'September',
                                '10' => 'October',
                                '11' => 'November',
                                '12' => 'December',
                            ])
                            ->default(now()->month)
                            ->required(),
                    ])
                    ->query(function (Builder $query, array $data) {
                        // Store the filter data in the request or session
                        request()->merge([
                            'month_filter' => $data['month'] ?? now()->month,
                            'year_filter' => $data['year'] ?? now()->year,
                        ]);
    
                        return $query->whereHas('pointages', function ($query) use ($data) {
                            $query->when(
                                isset($data['month']),
                                fn($q) => $q->whereMonth('date', $data['month'])
                            )
                            ->when(
                                isset($data['year']),
                                fn($q) => $q->whereYear('date', $data['year'])
                            );
                        });
                    }),
            ], layout: FiltersLayout::AboveContentCollapsible)
            ->actions([])
            ->bulkActions([]);
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
            'index' => Pages\ListSalaries::route('/'),
        ];
    }
}
