<?php

declare(strict_types=1);

namespace App\Modules\Orders\Application\Provider;

use App\Modules\Orders\Domain\Entity\Order;
use App\Modules\Orders\Domain\ValueObjects\OrderId;

interface OrderProviderInterface
{
    public function findById(OrderId $orderId): Order;
}