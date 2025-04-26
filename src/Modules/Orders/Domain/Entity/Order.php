<?php

declare(strict_types=1);

namespace App\Modules\Orders\Domain\Entity;

use App\Modules\Orders\Domain\Enums\Status;
use App\Modules\Orders\Domain\Exception\OrderException;
use App\Modules\Orders\Domain\ValueObjects\OrderId;
use App\Shared\Domain\AggregateRoot;
use App\Shared\Domain\Embeddable\Money;
use App\Shared\Domain\Enums\Currency;
use App\Shared\Domain\Trait\CreatedAtTrait;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[Entity]
#[Table(name: 'orders')]
#[HasLifecycleCallbacks]
class Order extends AggregateRoot
{
    use CreatedAtTrait;

    #[Embedded(class: Money::class)]
    private Money $total;

    /** @var Collection<int, Item> */
    #[OneToMany(targetEntity: Item::class, mappedBy: 'order', cascade: ['persist'], orphanRemoval: true)]
    private Collection $items;

    public function __construct(
        #[Id]
        #[Column(type: UuidType::NAME, unique: true)]
        private Uuid   $id,
        #[Column(type: Types::STRING, enumType: Status::class)]
        private Status $status,
    )
    {
        $this->createdAt = new DateTimeImmutable();
        $this->items = new ArrayCollection();
    }

    /** @param Item[] $items */
    public static function create(
        OrderId $orderId,
        Status  $status,
        array   $items,
    ): self {
        if (empty($items)) {
            throw new OrderException('order.empty_items');
        }

        $order = new self(
            id: $orderId->toUuid(),
            status: $status,
        );

        foreach ($items as $item) {
            $order->addItem($item);
        }

        return $order;
    }

    public function toArray(): array
    {
        return [];
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function addItem(Item $item): void
    {
        $item->setOrder($this);
        $this->items->add($item);

        $this->recalculateItemsCost();
    }

    public function getTotal(): Money
    {
        return $this->total;
    }

    /** @return Collection<int, Item> */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function setStatus(Status $status): void
    {
        $this->status = $status;
    }

    private function recalculateItemsCost(): void
    {
        if ($this->items->isEmpty()) {
            $this->total = new Money(0, Currency::PLN);

            return;
        }

        $this->total = $this->items->reduce(
            function (?Money $sum, Item $item): Money {
                $price = $item->getPrice();

                return $sum ? $sum->add($price) : $price;
            },
        );
    }
}