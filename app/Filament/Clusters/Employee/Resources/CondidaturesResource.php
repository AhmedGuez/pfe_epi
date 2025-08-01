<?php

namespace App\Filament\Clusters\Employee\Resources;

use App\Filament\Clusters\Employee;
use App\Filament\Clusters\Employee\Resources\CondidaturesResource\Pages;
use App\Filament\Clusters\Employee\Resources\CondidaturesResource\RelationManagers;
use App\Models\Candidate;
use App\Models\Condidatures;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class CondidaturesResource extends Resource
{
    protected static ?string $model = Candidate::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $cluster = Employee::class;

    protected static ?int $navigationSort = 1;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(20)
                    ->nullable(),
                
                Forms\Components\TextInput::make('position_applied')
                    ->required()
                    ->maxLength(255),

                FileUpload::make('resume')
                    ->label('Resume/CV')
                    ->directory('resumes')
                    ->nullable()
                    ->maxSize(2048) // 2MB
                    ->downloadable()
                    ->nullable()
                    ->preserveFilenames()->columnSpanFull(),
            
                
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull()
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('position_applied')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('resume')
                    ->label('Resume')
                    ->formatStateUsing(fn ($state) => $state ? 'Download' : '')
                    ->url(fn (Candidate $record) => $record->resume ? Storage::url($record->resume) : null)
                    ->openUrlInNewTab(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Add filters if needed
            ])
            ->actions([
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
            'index' => Pages\ListCondidatures::route('/'),
            // 'create' => Pages\CreateCondidatures::route('/create'),
            // 'edit' => Pages\EditCondidatures::route('/{record}/edit'),
        ];
    }
}
