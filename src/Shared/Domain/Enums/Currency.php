<?php

declare(strict_types=1);

namespace App\Shared\Domain\Enums;

enum Currency : string
{
    case PLN = 'PLN';

    case EUR = 'EUR';

    case USD = 'USD';

    case GBP = 'GBP';
}