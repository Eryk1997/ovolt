<?php

declare(strict_types=1);

namespace App\Modules\Products\Domain\Entity;

use App\Shared\Domain\AggregateRoot;
use App\Shared\Domain\Embeddable\Money;
use App\Shared\Domain\Trait\CreatedAtTrait;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
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

    public function __construct(
        #[Column(type: Types::STRING, unique: true)]
        private string $name,
        #[Embedded(class: Money::class)]
        private Money  $price,
    )
    {
        $this->createdAt = new DateTimeImmutable();
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