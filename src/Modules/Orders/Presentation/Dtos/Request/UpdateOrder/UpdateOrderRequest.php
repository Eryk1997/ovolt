<?php

declare(strict_types=1);

namespace App\Modules\Orders\Presentation\Dtos\Request\UpdateOrder;

use App\Modules\Orders\Application\Validator\Constraints\OrderStatusValue;
use Symfony\Component\Validator\Constraints\NotBlank;

class UpdateOrderRequest
{
    public function __construct(
        #[NotBlank]
        #[OrderStatusValue]
        public string $status,
    )
    {
    }
}