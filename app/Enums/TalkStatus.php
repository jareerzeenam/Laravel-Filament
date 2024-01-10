<?php

namespace App\Enums;

enum TalkStatus: string
{
    case SUBMITTED = 'Submitted';
    case ACCEPTED = 'Accepted';
    case REJECTED = 'Rejected';

}
