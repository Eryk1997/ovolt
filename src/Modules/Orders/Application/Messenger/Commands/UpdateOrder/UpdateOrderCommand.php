<?php

declare(strict_types=1);

namespace App\Modules\Orders\Application\Messenger\Commands\UpdateOrder;

use App\Modules\Orders\Domain\ValueObjects\OrderId;
use App\Shared\Domain\Messenger\CommandBus\Command;

readonly class UpdateOrderCommand implements Command
{
    public function __construct(
        public OrderId $orderId,
        public string $status,
    )
    {
    }
}