<?php

declare(strict_types=1);

namespace App\Modules\Orders\Application\OrderItem\Factories;

use App\Modules\Orders\Application\Messenger\Commands\CreateOrder\CreateOrderItemCommand;
use App\Modules\Orders\Domain\Entity\Item;
use App\Modules\Orders\Domain\ValueObjects\ItemId;
use App\Modules\Orders\Domain\ValueObjects\Name;
use App\Modules\Products\Application\Provider\ProductProvider;
use App\Shared\Domain\Embeddable\Money;
use App\Shared\Domain\Enums\Currency;

readonly class OrderItemByCreateOrderItemCommandFactory
{
    public function __construct(
        public ProductProvider $productProvider,
    )
    {
    }

    public function create(CreateOrderItemCommand $command): Item
    {
        $product = $this->productProvider->findById((int) $command->productId);

        return Item::create(
            id: ItemId::new(),
            price: new Money($command->price, Currency::PLN),
            quantity: $command->quantity,
            name: new Name($command->productName),
            product: $product,
        );
    }
}