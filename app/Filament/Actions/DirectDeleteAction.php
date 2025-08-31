<?php

namespace App\Filament\Actions;

use Filament\Tables\Actions\DeleteAction;
use Filament\Notifications\Notification;

class DirectDeleteAction extends DeleteAction
{public static function getDefaultName(): ?string
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