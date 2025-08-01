<?php

namespace App\Filament\Clusters\Calendrier\Resources\EventResource\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use App\Models\Event;
use Filament\Actions;
use Filament\Forms;
use Illuminate\Database\Eloquent\Model;

class GlobalEventCalendarWidget extends FullCalendarWidget
{
    public Model | string | null $model = Event::class;

    protected int | string | array $columnSpan = 'full';
    protected static ?string $pollingInterval = null; // Optional: Remove polling if using manual refresh

    protected static bool $isLazy = false;

    public function fetchEvents(array $fetchInfo): array
    {
        // Remove the dispatch call from here
        return Event::query()
            ->where('starts_at', '>=', $fetchInfo['start'])
            ->where('ends_at', '<=', $fetchInfo['end'])
            ->get()
            ->map(fn (Event $event) => [
                'id' => (string) $event->id,
                'title' => $event->name,
                'start' => $event->starts_at,
                'end' => $event->ends_at,
            ])
            ->all();
    }

    protected function headerActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('+')
                ->form([
                    Forms\Components\TextInput::make('name')
                        ->required(),
                    Forms\Components\DateTimePicker::make('starts_at')
                        ->required(),
                    Forms\Components\DateTimePicker::make('ends_at')
                        ->required(),
                ])
                ->using(fn (array $data) => Event::create($data))
                ->after(fn () => $this->dispatch('refresh')), // Correct event
        ];
    }

    protected function modalActions(): array
    {
        return [
            Actions\EditAction::make()
                ->record(fn (array $arguments) => Event::find($arguments['event']['id']))
                ->form([
                    Forms\Components\TextInput::make('name')
                        ->required(),
                    Forms\Components\DateTimePicker::make('starts_at')
                        ->required(),
                    Forms\Components\DateTimePicker::make('ends_at')
                        ->required(),
                ])
                ->after(fn () => $this->dispatch('refresh')), // Correct event
            
            Actions\DeleteAction::make()
                ->after(fn () => $this->dispatch('refresh')), // Add refresh for delete
        ];
    }

    public function updateEvent(array $eventData): void
    {
        if ($event = Event::find($eventData['id'])) {
            $event->update([
                'starts_at' => $eventData['start'],
                'ends_at' => $eventData['end'] ?? $eventData['start'],
            ]);
            $this->dispatch('refresh'); // Add refresh after update
        }
    }
}