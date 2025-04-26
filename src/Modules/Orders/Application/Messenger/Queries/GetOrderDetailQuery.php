<?php

declare(strict_types=1);

namespace App\Modules\Orders\Application\Messenger\Queries;

use App\Modules\Orders\Domain\ValueObjects\OrderId;
use App\Shared\Domain\Messenger\QueryBus\Query;

readonly class GetOrderDetailQuery implements Query
{
    public function __construct(public OrderId $orderId)
    {
    }
}