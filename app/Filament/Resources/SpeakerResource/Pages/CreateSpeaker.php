<?php

namespace App\Filament\Resources\SpeakerResource\Pages;

use App\Filament\Resources\SpeakerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateSpeaker extends CreateRecord
{
    protected static string $resource = SpeakerResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        dd($data);
    }
}
