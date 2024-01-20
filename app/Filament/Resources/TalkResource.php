<?php

namespace App\Filament\Resources;

use App\Enums\TalkLength;
use App\Enums\TalkStatus;
use App\Filament\Resources\TalkResource\Pages;
use App\Filament\Resources\TalkResource\RelationManagers;
use App\Models\Talk;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class TalkResource extends Resource
{
    protected static ?string $model = Talk::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('abstract')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\Select::make('speaker_id')
                    ->relationship('speaker', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->persistFiltersInSession()
            ->filtersTriggerAction(function ($action){
                return $action->button()->label('Filters');
            })
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                ->description(function (Talk $record){
                    return Str::of($record->abstract)->limit(40);
                })
                ,
                Tables\Columns\ImageColumn::make('speaker.avatar')
                    ->label('Speaker Avatar')
                    ->circular()
                    ->defaultImageUrl(function ($record) {
                        return 'https://ui-avatars.com/api/?background=0D8ABC&color=fff&name='. urlencode($record->speaker->name);
                    }),
//                Tables\Columns\TextColumn::make('abstract')
//                ->wrap(),
                Tables\Columns\TextInputColumn::make('speaker.name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('new_talk'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                ->sortable()
                ->color(function ($state) {
                    return $state->getColor();
                }),
                Tables\Columns\IconColumn::make('length')
                ->icon(function ($state) {
                    return match ($state) {
                        TalkLength::NORMAL => 'heroicon-o-megaphone',
                        TalkLength::LIGHTNING => 'heroicon-o-bolt',
                        TalkLength::KEYNOTE => 'heroicon-o-key'
                    };
                })
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('new_talk'),
                Tables\Filters\SelectFilter::make('speaker')
                ->relationship('speaker','name')
                ->multiple()
                ->searchable()
                ->preload(),
                Tables\Filters\Filter::make('has_avatar')
                    ->label('Show Only Speakers With Avatars')
                    ->toggle()
                    ->query(function ($query){
                        return $query->whereHas('speaker', function (Builder $query){
                            $query->whereNotNull('avatar');
                        });
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->slideOver(),

                Tables\Actions\ActionGroup::make([

                    Tables\Actions\Action::make('approve')
                        ->visible(function ($record) {
                            return $record->status === (TalkStatus::REJECTED) || $record->status === (TalkStatus::SUBMITTED);
                        })
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function (Talk $record) {
                            $record->approve();
                        })->after(function (){
                            Notification::make()
                                ->success()
                                ->duration(1000)
                                ->title('The talk was approved')
                                ->body('The speaker has bee notified and the talk has been added to the conference schedule.')
                                ->send();
                        }),

                    Tables\Actions\Action::make('reject')
                        ->icon('heroicon-o-no-symbol')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->visible(function ($record) {
                            return $record->status === (TalkStatus::ACCEPTED) || $record->status === (TalkStatus::SUBMITTED);
                        })
                        ->action(function (Talk $record) {
                            $record->reject();
                        })->after(function (){
                            Notification::make()
                                ->danger()
                                ->duration(1000)
                                ->title('The talk was rejected')
                                ->body('The speaker has bee notified.')
                                ->send();
                        })
                    ])
                ])

            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('approve')
                    ->action(function (Collection $records){
                        $records->each->approve();
                    }),
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make()
                ]),
            ])
            ->headerActions([
                Tables\Actions\Action::make('export')
                    ->tooltip('This will export all the visible and filtered data.')
                ->action(function ($livewire){

                    dd($livewire->getFilteredTableQuery()->get());
                })
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
            'index' => Pages\ListTalks::route('/'),
            'create' => Pages\CreateTalk::route('/create'),
//            'edit' => Pages\EditTalk::route('/{record}/edit'),
        ];
    }
}
