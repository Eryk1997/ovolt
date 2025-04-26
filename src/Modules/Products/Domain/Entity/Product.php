<?php

declare(strict_types=1);

namespace App\Modules\Products\Domain\Entity;

use App\Modules\Orders\Domain\Entity\Item;
use App\Shared\Domain\AggregateRoot;
use App\Shared\Domain\Embeddable\Money;
use App\Shared\Domain\Trait\CreatedAtTrait;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'products')]
#[HasLifecycleCallbacks]
class Product extends AggregateRoot
{
    use CreatedAtTrait;

    #[Id]
    #[GeneratedValue]
    #[Column]
    private int $id;

    /** @var Collection<int,Item> */
    #[OneToMany(targetEntity: Item::class, mappedBy: 'product', cascade: ['persist'])]
    private Collection $orderItems;

    public function __construct(
        #[Column(type: Types::STRING, unique: true)]
        private string $name,
        #[Embedded(class: Money::class)]
        private Money  $price,
    )
    {
        $this->createdAt = new DateTimeImmutable();
        $this->orderItems = new ArrayCollection();
    }

    public static function create(
        string $name,
        Money  $price,
    ): self
    {
        return new self(
            name: $name,
            price: $price,
        );
    }

    public function toArray(): array
    {
        return [];
    }

    public function getPrice(): Money
    {
        return $this->price;
    }

    public function getName(): string
    {
        return $this->name;
    }
}