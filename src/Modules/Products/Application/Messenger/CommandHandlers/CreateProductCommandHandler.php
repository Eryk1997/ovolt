<?php

declare(strict_types=1);

namespace App\Modules\Products\Application\Messenger\CommandHandlers;

use App\Modules\Products\Application\Exception\NotFoundProductException;
use App\Modules\Products\Application\Factories\ProductFactory;
use App\Modules\Products\Application\Messenger\Commands\CreateProductCommand;
use App\Modules\Products\Application\Provider\ProductProvider;
use App\Modules\Products\Domain\Repositories\ProductRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class CreateProductCommandHandler
{
    public function __construct(
        private ProductFactory             $productFactory,
        private ProductRepositoryInterface $productRepository,
        private ProductProvider            $productProvider,
    )
    {
    }

    public function __invoke(CreateProductCommand $createProductCommand): void
    {
        try {
            $this->productProvider->findByName($createProductCommand->name);
        } catch (NotFoundProductException) {
            $product = $this->productFactory->create($createProductCommand);

            $this->productRepository->save($product);
        }
    }
}