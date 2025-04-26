<?php

declare(strict_types=1);

namespace App\Modules\Orders\Application\Factories;

use App\Modules\Orders\Application\Messenger\Commands\CreateOrder\CreateOrderItemCommand;
use App\Modules\Orders\Presentation\Dtos\Request\CreateOrder\CreateOrderItemRequest;

readonly class CreateOrderItemCommandFactory
{
    public function createFromCreateOrderItemRequest(CreateOrderItemRequest $createOrderItemRequest): CreateOrderItemCommand
    {
        return new CreateOrderItemCommand(
            productId: $createOrderItemRequest->productId,
            productName: $createOrderItemRequest->productName,
            price: $createOrderItemRequest->price,
            quantity: $createOrderItemRequest->quantity,
        );
    }
}