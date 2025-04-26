<?php

declare(strict_types=1);

namespace App\Modules\Orders\Application\Messenger\Commands\CreateOrder;

use App\Modules\Orders\Domain\ValueObjects\OrderId;
use App\Shared\Domain\Messenger\CommandBus\Command;

readonly class CreateOrderCommand implements Command
{
    /** @param CreateOrderItemCommand[] $items */
    public function __construct(
        public OrderId $id,
        public array $items,
    )
    {
    }
}