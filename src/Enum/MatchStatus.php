<?php

namespace App\Enum;


enum MatchStatus: string
{
    case WAITING = 'waiting';
    case ACCEPTED = 'accepted';
    case REFUSED = 'refused';

}
