<?php

declare(strict_types=1);

namespace App\Modules\Products\Application\Messenger\Commands;

use App\Shared\Domain\Messenger\CommandBus\Command;

readonly class CreateProductCommand implements Command
{
    public function __construct(
        public string $name,
        public int $price,
    )
    {
    }
}