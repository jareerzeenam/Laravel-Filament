<?php

namespace App\Models;

use App\Enums\Region;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Conference extends Model
{
    use HasFactory;

    protected $casts = [
        'id' => 'integer',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'venue_id' => 'integer',
        'region' => Region::class,
    ];

    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

    public function speakers(): BelongsToMany
    {
        return $this->belongsToMany(Speaker::class);
    }

    public function talks(): BelongsToMany
    {
        return $this->belongsToMany(Talk::class);
    }

    public static function getForm():array
    {
        return [
            Tabs::make()
                ->columnSpanFull()
            ->tabs([
                Tabs\Tab::make('Conference Details')
                ->schema([
                    Section::make('Conference Details')
                        ->collapsible()
                        ->columns([ 'md'=>2, 'lg'=>3 ])
                        ->description('some description here')
                        ->icon('heroicon-o-academic-cap')
                        ->schema([
                            TextInput::make('name')
                                ->columnSpanFull()
                                ->label('Conference Name')
                                ->helperText('The name of the conference.')
                                ->hint('Here is the hint.')
                                ->hintIcon('heroicon-o-rectangle-stack')
                                ->required()
                                ->maxLength(255),

                            MarkdownEditor::make('description')
                                ->columnSpanFull()
                                ->required(),

                            DateTimePicker::make('start_date')
                                ->native(false)
                                ->required(),

                            DateTimePicker::make('end_date')
                                ->required(),

                            Fieldset::make('Status')
                                ->columns(1)
                                ->schema([
                                    Select::make('status')
                                        ->options([
                                            'default'=>'Default',
                                            'published'=>'Published',
                                            'archived'=>'Archived',
                                        ])
                                        ->required(),

                                    Toggle::make('is_publish')
                                        ->columnSpanFull()
                                        ->default(false)
                                        ->required(),
                                ])
                        ]),
                ]),

                Tabs\Tab::make('Location')
                ->schema([
                    Section::make('Location')
                        ->columns(2)
                        ->schema([
                            Select::make('region')
                                ->live()
                                ->enum(Region::class)
                                ->options(Region::class),

                            Select::make('venue_id')
                                ->searchable()
                                ->preload()
                                ->createOptionForm(Venue::getForm())
                                ->editOptionForm(Venue::getForm())
                                ->relationship('venue', 'name', modifyQueryUsing: function (Builder $query, Get $get){
                                    return $query->where('region', $get('region'));
                                }),
                        ]),
                ]),


            ]),
//           Action to test on development environment
            Actions::make([
                Actions\Action::make('star')
                    ->label('Fill with Factory Data')
                    ->icon('heroicon-m-star')
                    ->visible(function (string $operation) {

                        if ($operation != 'create'){
                            return false;
                        }

                        if (!app()->environment('local')) {
                            return false;
                        }

                        return true;
                    })
                    ->requiresConfirmation()
                    ->action(function ($livewire) {
                        $data = Conference::factory()->make()->toArray();
                        $livewire->form->fill($data);
                    }),
            ]),







//            CheckboxList::make('speakers')
//                ->relationship('speakers','name')
//                ->options(Speaker::all()->pluck('name','id'))
//                ->required()
        ];
    }
}
