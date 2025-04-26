<?php

declare(strict_types=1);

namespace App\Modules\Orders\Domain\Repositories;

use App\Modules\Orders\Domain\Entity\Order;

interface OrderRepositoryInterface
{
    public function save(Order $order): void;
}