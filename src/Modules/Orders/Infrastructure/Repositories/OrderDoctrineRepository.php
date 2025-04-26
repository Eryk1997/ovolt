<?php

declare(strict_types=1);

namespace App\Modules\Orders\Infrastructure\Repositories;

use App\Modules\Orders\Domain\Entity\Order;
use App\Modules\Orders\Domain\Repositories\OrderRepositoryInterface;
use App\Modules\Products\Domain\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends  ServiceEntityRepository<Product>
 */
class OrderDoctrineRepository extends ServiceEntityRepository implements OrderRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function save(Order $order): void
    {
        $em = $this->getEntityManager();

        $em->persist($order);
        $em->flush();
    }
}