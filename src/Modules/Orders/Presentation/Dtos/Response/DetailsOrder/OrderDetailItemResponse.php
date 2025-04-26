<?php

declare(strict_types=1);

namespace App\Modules\Orders\Presentation\Dtos\Response\DetailsOrder;

use App\Modules\Orders\Application\Dtos\OrderDetail\OrderDetailItemDto;
use App\Shared\Presentation\Dtos\FrontendMoneyResponse;

readonly class OrderDetailItemResponse
{
    public function __construct(
        public FrontendMoneyResponse $price,
        public int $quantity,
        public string $productName,
    )
    {
    }

    public static function fromItem(OrderDetailItemDto $item): self
    {
        return new self(
            price: FrontendMoneyResponse::from($item->price),
            quantity: $item->quantity,
            productName: $item->productName,
        );
    }

    /**
     * @param OrderDetailItemDto[] $items
     * @return self[]
     */
    public static function multipleFromItems(array $items): array
    {
        $map = [];

        foreach ($items as $item) {
            $map[] = self::fromItem($item);
        }

        return $map;
    }
}