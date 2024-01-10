<?php

namespace App\Enums;

enum TalkStatus: string
{
    case SUBMITTED = 'Submitted';
    case ACCEPTED = 'Accepted';
    case REJECTED = 'Rejected';

    public function getColor(): string
    {
        return match ($this) {
            self::SUBMITTED => 'primary',
            self::ACCEPTED => 'success',
            self::REJECTED => 'danger',
        };
    }

}
