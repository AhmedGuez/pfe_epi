<?php

namespace App\Filament\Clusters\Sanction\Resources;

use App\Filament\Clusters\Sanction;
use App\Filament\Clusters\Sanction\Resources\QuestionnaireResource\Pages;
use App\Filament\Clusters\Sanction\Resources\QuestionnaireResource\RelationManagers;
use App\Models\Questionnaire;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuestionnaireResource extends Resource
{
    protected static ?string $model = Questionnaire::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';
    protected static ?int $navigationSort = 1;


    protected static ?string $cluster = Sanction::class;

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Select::make('employe_id')
                    ->relationship('employe', 'full_name') // Adjust to your `Employee` model name field
                    ->required(),
            
            Forms\Components\Textarea::make('question')
                ->label('Question')
                ->required(),

                SpatieMediaLibraryFileUpload::make('fichier_joint')->columnSpan(1)->label('Fichier Joint')->columnSpanFull(),       

               
        ]);
}

public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make(name: 'employe.full_name')->label('Nom Employee')->searchable()->sortable()->alignCenter(),
         

            Tables\Columns\TextColumn::make('question')
                ->label('Question')
                ->limit(50) // Limit text in the table view
                ->searchable(),

            Tables\Columns\TextColumn::make('created_at')
                ->label('Créé le')
                ->dateTime('d/m/Y'),
        ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Action::make('downloadquestionaire')
                ->label('Download')
                ->icon('heroicon-o-arrow-down-tray')
                ->url(fn(Questionnaire $record) => route('questionaire.download', $record))
                ->openUrlInNewTab()
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
            'index' => Pages\ListQuestionnaires::route('/'),
            'create' => Pages\CreateQuestionnaire::route('/create'),
            'edit' => Pages\EditQuestionnaire::route('/{record}/edit'),
        ];
    }
}
