<?php

declare(strict_types=1);

namespace App\Modules\Orders\Presentation\Dtos\Request\CreateOrder;

use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Valid;

class CreateOrderRequest
{
    /** @param CreateOrderItemRequest[] $items */
    public function __construct(
        #[NotBlank]
        #[Count(min: 1)]
        #[Valid]
        public array $items,
    )
    {
    }
}