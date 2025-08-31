<?php

namespace App\Filament\Actions;

use Filament\Tables\Actions\DeleteAction;
use Filament\Notifications\Notification;

class DirectDeleteAction extends DeleteAction
<<<<<<< HEAD
{public static function getDefaultName(): ?string
=======
{
    public static function getDefaultName(): ?string
>>>>>>> 134b51d099f5bef095a026a6918f45d39e8d1d54
    {
        return 'delete';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label('Delete')
            ->color('danger')
            ->icon('heroicon-m-trash')
            ->action(static function ($record): void {
                $record->delete();

                // Send a success notification
                Notification::make()
                    ->title('Deleted successfully')
                    ->success()
                    ->send();
            });
    }
}