<?php

declare(strict_types=1);

namespace App\Modules\Orders\Domain\Repositories;

use App\Modules\Orders\Domain\Entity\Order;
use App\Modules\Orders\Domain\ValueObjects\OrderId;

interface OrderQueryRepositoryInterface
{
    public function findById(OrderId $orderId): ?Order;
}