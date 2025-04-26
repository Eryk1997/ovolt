<?php

declare(strict_types=1);

namespace App\Shared\Domain\Embeddable;

use App\Shared\Domain\Enums\Currency;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;

#[Embeddable]
readonly class Money
{
    public function __construct(
        #[Column(type: Types::BIGINT)]
        private int    $value,
        #[Column(type: Types::STRING, length: 3, enumType: Currency::class)]
        private Currency $currency = Currency::PLN
    )
    {
        if ($value < 0) {
            throw new \InvalidArgumentException('Tried to create Money with negative value');
        }
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function add(Money $money): self
    {
        if ($this->currency !== $money->getCurrency()) {
            throw new \InvalidArgumentException('Inconsistent currency.');
        }

        return new Money($this->value + $money->getValue(), $this->currency);
    }

    public function divideToMoney(float|int $value): self
    {
        return new self((int) round($this->value / $value), $this->currency);
    }

    public function isEqualTo(Money $money): bool
    {
        if ($this->currency !== $money->getCurrency()) {
            throw new \InvalidArgumentException('Inconsistent currency.');
        }

        return $this->value === $money->getValue();
    }
}