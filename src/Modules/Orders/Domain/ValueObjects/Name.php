<?php

declare(strict_types=1);

namespace App\Modules\Orders\Domain\ValueObjects;

use App\Modules\Orders\Domain\Exception\OrderItemException;

final class Name
{
    private const MAX_LENGTH = 255;

    private string $name;

    public function __construct(string $value)
    {
        $this->name = $value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    private function valid(string $value): void
    {
        if (strlen($value) > self::MAX_LENGTH) {
            throw new OrderItemException('order.item.name.max_length', ['%max%' => self::MAX_LENGTH]);
        }
    }
}