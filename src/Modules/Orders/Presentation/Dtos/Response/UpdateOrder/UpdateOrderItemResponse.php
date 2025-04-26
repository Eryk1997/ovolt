<?php

declare(strict_types=1);

namespace App\Modules\Orders\Presentation\Dtos\Response\UpdateOrder;

use App\Modules\Orders\Domain\Entity\Item;
use App\Shared\Presentation\Dtos\FrontendMoneyResponse;

readonly class UpdateOrderItemResponse
{
    public function __construct(
        public FrontendMoneyResponse $price,
        public int $quantity,
        public string $productName,
    )
    {
    }

    public static function fromItem(Item $item): self
    {
        return new self(
            price: FrontendMoneyResponse::from($item->getPrice()),
            quantity: $item->getQuantity(),
            productName: $item->getName(),
        );
    }

    /**
     * @param Item[] $items
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