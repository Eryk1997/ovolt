<?php

namespace App\Modules\Products\Infrastructure\Repositories;

use App\Modules\Products\Domain\Entity\Product;
use App\Modules\Products\Domain\Repositories\ProductRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends  ServiceEntityRepository<Product>
 */
class ProductDoctrineRepository extends ServiceEntityRepository implements ProductRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function save(Product $product): void
    {
        $em = $this->getEntityManager();

        $em->persist($product);
        $em->flush();
    }

    public function findByName(string $name): ?Product
    {
        return $this->createQueryBuilder('products')
            ->where('products.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}