<?php

declare(strict_types=1);

namespace App\Modules\Orders\Application\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class OrderStatusValue extends Constraint
{
    public string $message = 'order.status.valid_option';
}