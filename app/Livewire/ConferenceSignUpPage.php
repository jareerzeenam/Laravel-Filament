<?php

namespace App\Livewire;

use App\Models\Attendee;
use App\Models\Conference;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Illuminate\Support\HtmlString;
use Livewire\Component;

class ConferenceSignUpPage extends Component implements HasForms, HasActions
{
    use InteractsWithActions, InteractsWithForms;

    public int $conferenceId;
    public int $price = 5000;

    public function mount(int $conferenceId)
    {
        $this->conferenceId = $conferenceId;
    }
    public function signUpAction(): Action
    {
        return Action::make('signUp')
            ->slideOver()
            ->form([
                Placeholder::make('total_price')
                    ->hiddenLabel()
                ->content(function (Get $get) {
//                    dd(count($get('attendees')));
                    return '$' . count($get('attendees')) * $this->price;
                }),
                Repeater::make('attendees')
                    ->schema(Attendee::grtForm())
            ])
            ->action(function ( array $data) {
                collect($data['attendees'])->each(function (array $data) {
                    Attendee::create([
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'ticket_cost' => $this->price,
                        'is_paid' => true,
                        'conference_id' => $this->conferenceId,
                    ]);
                });

            })
            ->after(function () {
                Notification::make()->success()->title('Success!')
                    ->body(new HtmlString('You have successfully signed up for the conference.'))
                    ->send();
            });
    }
    public function render()
    {
        return view('livewire.conference-sign-up-page');
    }
}
