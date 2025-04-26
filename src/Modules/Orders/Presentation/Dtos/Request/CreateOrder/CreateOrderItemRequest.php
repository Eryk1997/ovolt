<?php

declare(strict_types=1);

namespace App\Modules\Orders\Presentation\Dtos\Request\CreateOrder;

use App\Modules\Products\Application\Validator\Constraints\ProductExists;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreateOrderItemRequest
{
    public function __construct(
        #[NotBlank]
        #[ProductExists]
        public string $productId,
        #[NotBlank]
        #[Length(min: 1, max: 255)]
        public string $productName,
        #[NotBlank]
        #[GreaterThanOrEqual(0)]
        public int $price,
        #[NotBlank]
        #[GreaterThan(0)]
        public int $quantity,
    )
    {
    }
}