<?php

declare(strict_types=1);

namespace App\Modules\Orders\Domain\Enums;

enum Status: string
{
    case NEW = 'new';

    case PAID = 'paid';

    case SHIPPED = 'shipped';

    case CANCELLED = 'cancelled';
}
