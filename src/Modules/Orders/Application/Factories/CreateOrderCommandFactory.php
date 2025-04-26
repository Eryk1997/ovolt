<?php

declare(strict_types=1);

namespace App\Modules\Orders\Application\Factories;

use App\Modules\Orders\Application\Messenger\Commands\CreateOrder\CreateOrderCommand;
use App\Modules\Orders\Application\Messenger\Commands\CreateOrder\CreateOrderItemCommand;
use App\Modules\Orders\Domain\ValueObjects\OrderId;
use App\Modules\Orders\Presentation\Dtos\Request\CreateOrder\CreateOrderRequest;

readonly class CreateOrderCommandFactory
{
    public function __construct(
        public CreateOrderItemCommandFactory $createOrderItemCommandFactory,
    )
    {
    }

    public function createFromRequest(OrderId $id, CreateOrderRequest $createOrderRequest): CreateOrderCommand
    {
        $items = $this->getItems($createOrderRequest);

        return new CreateOrderCommand(
            id: $id,
            items: $items,
        );
    }

    /** @return CreateOrderItemCommand[] */
    private function getItems(CreateOrderRequest $createOrderRequest): array
    {
        $items = [];

        foreach ($createOrderRequest->items as $item) {
            $items[] = $this->createOrderItemCommandFactory->createFromCreateOrderItemRequest($item);
        }

        return $items;
    }
}