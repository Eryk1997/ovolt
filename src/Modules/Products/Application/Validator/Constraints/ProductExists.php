<?php

declare(strict_types=1);

namespace App\Modules\Products\Application\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class ProductExists extends Constraint
{
    public string $message = "product.not_found_id";
}