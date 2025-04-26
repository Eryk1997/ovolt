<?php

declare(strict_types=1);

namespace App\Modules\Orders\Application\Factories;

use App\Modules\Orders\Application\Messenger\Commands\CreateOrder\CreateOrderCommand;
use App\Modules\Orders\Application\OrderItem\Factories\OrderItemByCreateOrderItemCommandFactory;
use App\Modules\Orders\Domain\Entity\Item;
use App\Modules\Orders\Domain\Entity\Order;
use App\Modules\Orders\Domain\Enums\Status;

readonly class OrderByCreateOrderCommandFactory
{
    public function __construct(
        private OrderItemByCreateOrderItemCommandFactory $orderItemCommandFactory,
    )
    {
    }

    public function create(CreateOrderCommand $createOrderCommand): Order
    {
        $orderItems = $this->getItems($createOrderCommand);

        return Order::create(
            orderId: $createOrderCommand->id,
            status: Status::NEW,
            items: $orderItems,
        );
    }

    /** @return Item[] */
    private function getItems(CreateOrderCommand $createOrderCommand): array
    {
        $orderItems = [];

        foreach ($createOrderCommand->items as $itemCommand) {
            $item = $this->orderItemCommandFactory->create($itemCommand);

            $orderItems[] = $item;
        }

        return $orderItems;
    }
}