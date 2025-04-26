<?php

declare(strict_types=1);

namespace App\Modules\Orders\Presentation\Dtos\Response\DetailsOrder;

use App\Modules\Orders\Application\Dtos\OrderDetail\OrderDetailDto;
use App\Shared\Presentation\Dtos\FrontendMoneyResponse;

readonly class OrderDetailResponse
{
    /** @param OrderDetailItemResponse[] $items */
    public function __construct(
        public string $status,
        public string $createdAt,
        public FrontendMoneyResponse $total,
        public array $items,
    )
    {
    }

    public static function fromOrderDetailDto(OrderDetailDto $orderDetailDto): self
    {
        $items = OrderDetailItemResponse::multipleFromItems($orderDetailDto->items);

        return new self(
            status: $orderDetailDto->status,
            createdAt: $orderDetailDto->createdAt,
            total: FrontendMoneyResponse::from($orderDetailDto->total),
            items: $items,
        );
    }
}