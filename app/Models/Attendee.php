<?php

namespace App\Models;

use Filament\Forms\Components\Group;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendee extends Model
{
    use HasFactory;

    public function conference(): BelongsTo
    {
        return  $this->belongsTo(Conference::class);
    }

    public static function grtForm(): array
    {
        return [
            Group::make()->columns(2)->schema([
                TextInput::make('name')
                    ->autofocus()
                    ->required()
                    ->placeholder('John Doe')
                    ->maxLength(255),

                TextInput::make('email')
                    ->email()
                    ->required()
                    ->placeholder('example@email.com')
                    ->maxLength(255),
            ])
        ];
    }
}
