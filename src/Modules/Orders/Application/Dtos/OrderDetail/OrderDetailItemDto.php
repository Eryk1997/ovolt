<?php

declare(strict_types=1);

namespace App\Modules\Orders\Application\Dtos\OrderDetail;

use App\Modules\Orders\Domain\Entity\Item;
use App\Shared\Domain\Embeddable\Money;

class OrderDetailItemDto
{
    public function __construct(
        public Money $price,
        public int $quantity,
        public string $productName,
    )
    {
    }

    public static function fromItem(Item $item): self
    {
        return new self(
            price: $item->getPrice(),
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