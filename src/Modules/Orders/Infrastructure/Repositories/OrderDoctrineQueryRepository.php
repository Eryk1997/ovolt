<?php

declare(strict_types=1);

namespace App\Modules\Orders\Infrastructure\Repositories;

use App\Modules\Orders\Domain\Entity\Order;
use App\Modules\Orders\Domain\Repositories\OrderQueryRepositoryInterface;
use App\Modules\Orders\Domain\ValueObjects\OrderId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Order>
 *
 * @method null|Order find($id, $lockMode = null, $lockVersion = null)
 * @method null|Order findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderDoctrineQueryRepository extends ServiceEntityRepository implements OrderQueryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function findById(OrderId $orderId): ?Order
    {
        return $this->createQueryBuilder('orders')
            ->where('orders.id = :id')
            ->setParameter('id', $orderId->toUuid()->toBinary())
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}