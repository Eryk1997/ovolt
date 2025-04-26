<?php

namespace App\Shared\Domain\Enums;

enum Currency : string
{
    case PLN = 'PLN';

    case EUR = 'EUR';

    case USD = 'USD';

    case GBP = 'GBP';
}