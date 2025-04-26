<?php

declare(strict_types=1);

namespace App\Modules\Orders\Presentation\Dtos\Response\CreateOrder;

use App\Modules\Orders\Domain\Entity\Order;
use App\Shared\Presentation\Dtos\FrontendMoneyResponse;

readonly class CreateOrderResponse
{
    /** @param CreateOrderItemResponse[] $items */
    public function __construct(
        public string $id,
        public FrontendMoneyResponse $total,
        public string                $createdAt,
        public string                $status,
        public array                 $items,
    )
    {
    }

    public static function fromOrder(Order $order): self
    {
        $items = CreateOrderItemResponse::multipleFromItems($order->getItems()->toArray());

        return new self(
            id: $order->getId()->toString(),
            total: FrontendMoneyResponse::from($order->getTotal()),
            createdAt: $order->getCreatedAt()->format('Y-m-d H:i:s'),
            status: $order->getStatus()->value,
            items: $items,
        );
    }
}