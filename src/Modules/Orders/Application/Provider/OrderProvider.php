<?php

declare(strict_types=1);

namespace App\Modules\Orders\Application\Provider;

use App\Modules\Orders\Application\Exception\NotFoundOrderException;
use App\Modules\Orders\Domain\Entity\Order;
use App\Modules\Orders\Domain\Repositories\OrderQueryRepositoryInterface;
use App\Modules\Orders\Domain\ValueObjects\OrderId;

final readonly class OrderProvider implements OrderProviderInterface
{
    public function __construct(
        private OrderQueryRepositoryInterface $orderQueryRepository,
    )
    {
    }

    public function findById(OrderId $orderId): Order
    {
        $order = $this->orderQueryRepository->findById($orderId);

        if (!$order) {
            throw new NotFoundOrderException('order.not_found');
        }

        return $order;
    }
}