<?php

declare(strict_types=1);

namespace App\Modules\Products\Domain\Repositories;

use App\Modules\Products\Domain\Entity\Product;

interface ProductRepositoryInterface
{
    public function save(Product $product): void;

    public function findByName(string $name): ?Product;
}