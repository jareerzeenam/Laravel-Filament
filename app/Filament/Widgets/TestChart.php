<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\AttendeeResource;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Widgets\Widget;

class TestChart extends Widget implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    protected int | string | array $columnSpan = 'full';
    protected static string $view = 'filament.widgets.test-chart';

    public function callNotification(): Action
    {
        return Action::make('callNotification')
            ->button()
            ->color('warning')
            ->label('Send A Notification')
            ->action(function (){
                Notification::make()->warning()
                    ->title('This is a test notification')
                    ->body('You have successfully sent a notification')
                    //->duration(5000) // This will make the notification stay for 5 seconds (5000 milliseconds
                    ->persistent() // This will make the notification stay until the user dismisses it
                    ->actions([
                        \Filament\Notifications\Actions\Action::make('gotToAttendees')
                            ->button()
                            ->color('success')
                            ->url(AttendeeResource::getUrl('edit',['record' => 1])),

                        \Filament\Notifications\Actions\Action::make('undo')
                        ->link()
                        ->color('danger')
                        ->action(function () {
                            dd('Undo');
                        }),
                    ])
                    ->send();
            });
    }
}
