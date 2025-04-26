<?php

declare(strict_types=1);

namespace App\Modules\Orders\Application\Messenger\QueryHandlers;

use App\Modules\Orders\Application\Dtos\OrderDetail\OrderDetailDto;
use App\Modules\Orders\Application\Messenger\Queries\GetOrderDetailQuery;
use App\Modules\Orders\Application\Provider\OrderProvider;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class GetOrderDetailQueryHandler
{
    public function __construct(private OrderProvider $orderProvider)
    {
    }

    public function __invoke(GetOrderDetailQuery $query): OrderDetailDto
    {
        $order = $this->orderProvider->findById($query->orderId);

        return OrderDetailDto::fromOrder($order);
    }
}