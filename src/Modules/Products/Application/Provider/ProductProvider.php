<?php

declare(strict_types=1);

namespace App\Modules\Products\Application\Provider;

use App\Modules\Products\Application\Exception\NotFoundProductException;
use App\Modules\Products\Domain\Entity\Product;
use App\Modules\Products\Domain\Repositories\ProductRepositoryInterface;

final readonly class ProductProvider
{
    public function __construct(
        private ProductRepositoryInterface $productRepository
    )
    {
    }

    public function findByName(string $name): Product
    {
        $product = $this->productRepository->findByName($name);

        if (!$product) {
            throw new NotFoundProductException("product.not_found_name", ['%name%' => $name]);
        }

        return $product;
    }
}