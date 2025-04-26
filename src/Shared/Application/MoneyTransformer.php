<?php

declare(strict_types=1);

namespace App\Shared\Application;

use App\Shared\Domain\Embeddable\Money;

class MoneyTransformer
{
    public static function toFloatFromMoney(Money $money): float
    {
        return (float) ($money->getValue() / 100);
    }
}