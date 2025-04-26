<?php

declare(strict_types=1);

namespace App\Modules\Products\Application\Factories;

use App\Modules\Products\Application\Messenger\Commands\CreateProductCommand;
use App\Modules\Products\Domain\Entity\Product;
use App\Shared\Domain\Embeddable\Money;
use App\Shared\Domain\Enums\Currency;

class ProductFactory
{
    public function create(CreateProductCommand $createProductCommand): Product
    {
        return Product::create(
            name: $createProductCommand->name,
            price: new Money($createProductCommand->price, Currency::PLN),
        );
    }
}