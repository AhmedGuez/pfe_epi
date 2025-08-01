<?php

namespace App\Filament\Clusters\Employee\Resources;

use App\Enums\Affected;
use App\Enums\AffectedType;
use App\Enums\ContractType;
use App\Filament\Clusters\Employee;
use App\Filament\Clusters\Employee\Resources\EmployeesResource\Pages;
use App\Filament\Clusters\Employee\Resources\EmployeesResource\RelationManagers;
use App\Models\Department;
use App\Models\Employees;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeesResource extends Resource
{
    protected static ?string $cluster = Employee::class;
    protected static ?string $model = Employees::class;


    protected static ?string $navigationLabel = "Employés";

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    protected static ?int $navigationSort = 0;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('')->schema([

                TextInput::make('code')->unique(ignoreRecord: true)->required(),

               TextInput::make('full_name')->label('Nom et Prénom')->placeholder('Nom et Prénom')->required(),

                DatePicker::make('hire_date')
                ->default(now())
                ->label("Date d'embauche")
                ->required(),   

                ToggleButtons::make('contract_type')
                ->options(ContractType::class)
                ->required()->columns(4), 

                ToggleButtons::make('affected')
                ->options(Affected::class)
                ->required()->columns(2), 

                
                ]),

                
              
                Section::make('')->schema([
                    // Select::make('department_id')
                    // ->label('Departement')
                    // ->options(Department::all()->pluck('name', 'id')->filter())
                    // ->searchable(),
               TextInput::make('post')->label('Poste')->placeholder('Position'),
               TextInput::make('cin')->label('Cin')->placeholder('12842232'),
               TextInput::make('phone_number')->label('N° Téléphone')->placeholder('+216'),
               TextInput::make('address')->label('Adresse')->placeholder('Adresse ou Ville'),
               Select::make('situation')
               ->label('Situation')
               ->options([
                   'marie' => 'Marié(e)',
                   'celibataire' => 'Célibataire',
                   'divorce' => 'Divorcé(e)',
               ]),
           
           TextInput::make('nombre_enfants')
               ->label('Nombre d\'enfants')
               ->placeholder('Nombre d\'enfants')
               ->numeric(),
           
               TextInput::make('prix_heure')->label("Prix D'heure")->numeric()->required(),
                ])->columns(3),
              

              
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')->label('Code Employee')->searchable()->sortable()->alignCenter(),
                TextColumn::make('full_name')->label('Nom Employee')->searchable()->sortable()->alignCenter(),
                TextColumn::make('affected')->searchable()->sortable()->alignCenter(),
                TextColumn::make('post')->label('Poste')->searchable()->sortable()->alignCenter(),
                TextColumn::make('phone_number')->label('N° Téléphone')->searchable()->sortable()->alignCenter(),
                TextColumn::make('contract_type')->searchable()->sortable()->alignCenter()->label('Type de Contrat'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label(''),
                Tables\Actions\EditAction::make()->label(''),
                Tables\Actions\DeleteAction::make()->label(''),
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
            'index' => Pages\ListEmployees::route('/'),
            // 'create' => Pages\CreateEmployees::route('/create'),
            // 'edit' => Pages\EditEmployees::route('/{record}/edit'),
        ];
    }
}
