<?php

declare(strict_types=1);

namespace App\Shared\Domain\Messenger\QueryBus;

interface QueryBus
{
    public function handle(Query $query): mixed;

    public function cacheExist(Query $query): bool;
}