<?php

declare(strict_types=1);

namespace App\Shared\Presentation\Dtos;

use App\Shared\Application\MoneyTransformer;
use App\Shared\Domain\Embeddable\Money;

class FrontendMoneyResponse
{
    public function __construct(
        public ?float $value = null,
        public ?string $currency = null,
    ) {
    }

    public static function from(Money $money): self
    {
        return new self(
            value: MoneyTransformer::toFloatFromMoney($money),
            currency: $money->getCurrency()->value,
        );
    }
}