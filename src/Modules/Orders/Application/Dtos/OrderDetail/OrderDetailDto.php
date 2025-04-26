<?php

declare(strict_types=1);

namespace App\Modules\Orders\Application\Dtos\OrderDetail;

use App\Modules\Orders\Domain\Entity\Order;
use App\Shared\Domain\Embeddable\Money;

class OrderDetailDto
{
    /** @param OrderDetailItemDto[] $items */
    public function __construct(
        public string $status,
        public string $createdAt,
        public Money $total,
        public array $items,
    )
    {
    }

    public static function fromOrder(Order $order): self
    {
        $items = OrderDetailItemDto::multipleFromItems($order->getItems()->toArray());

        return new self(
            status: $order->getStatus()->value,
            createdAt: $order->getCreatedAt()->format('Y-m-d H:i:s'),
            total: $order->getTotal(),
            items: $items,
        );
    }
}