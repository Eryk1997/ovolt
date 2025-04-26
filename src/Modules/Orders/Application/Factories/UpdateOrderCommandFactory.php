<?php

declare(strict_types=1);

namespace App\Modules\Orders\Application\Factories;

use App\Modules\Orders\Application\Messenger\Commands\UpdateOrder\UpdateOrderCommand;
use App\Modules\Orders\Domain\ValueObjects\OrderId;
use App\Modules\Orders\Presentation\Dtos\Request\UpdateOrder\UpdateOrderRequest;

readonly class UpdateOrderCommandFactory
{
    public function createFromRequest(OrderId $orderId, UpdateOrderRequest $updateOrderRequest): UpdateOrderCommand
    {
        return new UpdateOrderCommand(
            orderId: $orderId,
            status: $updateOrderRequest->status,
        );
    }
}