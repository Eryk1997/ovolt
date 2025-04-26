<?php

declare(strict_types=1);

namespace App\Modules\Orders\Domain\Entity;

use App\Modules\Orders\Domain\Exception\OrderItemException;
use App\Modules\Orders\Domain\ValueObjects\ItemId;
use App\Modules\Orders\Domain\ValueObjects\Name;
use App\Modules\Products\Domain\Entity\Product;
use App\Shared\Domain\AggregateRoot;
use App\Shared\Domain\Embeddable\Money;
use App\Shared\Domain\Trait\CreatedAtTrait;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[Entity]
#[Table(name: 'order_items')]
#[HasLifecycleCallbacks]
class Item extends AggregateRoot
{
    use CreatedAtTrait;

    #[ManyToOne(targetEntity: Order::class, cascade: ['persist'], inversedBy: 'items')]
    #[JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Order  $order = null;

    public function __construct(
        #[Id]
        #[Column(type: UuidType::NAME, unique: true)]
        private Uuid    $id,
        #[Embedded(class: Money::class)]
        private Money   $price,
        #[Column(type: Types::INTEGER)]
        private int     $quantity,
        #[Column(type: Types::STRING)]
        private string  $name,
        #[ManyToOne(targetEntity: Product::class, cascade: ['persist'], inversedBy: 'orderItems')]
        private Product $product,
    )
    {
        $this->createdAt = new DateTimeImmutable();
    }

    public static function create(
        ItemId  $id,
        Money   $price,
        int     $quantity,
        Name    $name,
        Product $product,
    ): self
    {
        self::checkPrice(
            product: $product,
            price: $price,
            quantity: $quantity,
        );

        return new self(
            id: $id->toUuid(),
            price: $price,
            quantity: $quantity,
            name: $name->getName(),
            product: $product
        );
    }

    public function toArray(): array
    {
        return [];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setOrder(Order $order): void
    {
        if ($this->order !== null) {
            throw new \RuntimeException('Order is already set.');
        }

        $this->order = $order;
    }

    public function getPrice(): Money
    {
        return $this->price;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    private static function checkPrice(Product $product, Money $price, int $quantity): void
    {
        $divideItemPrice = $price->divideToMoney($quantity);

        if (!$product->getPrice()->isEqualTo($divideItemPrice)) {
            throw new OrderItemException('order.item.price', ['%name%' => $product->getName()]);
        }
    }
}