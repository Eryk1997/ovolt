<?php

declare(strict_types=1);

namespace App\Modules\Orders\Application\Messenger\Commands\CreateOrder;

readonly class CreateOrderItemCommand
{
    public function __construct(
        public string $productId,
        public string $productName,
        public int $price,
        public int $quantity,
    )
    {
    }
}