<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Messenger\QueryBus;

use App\Shared\Domain\Messenger\QueryBus\Query;
use App\Shared\Domain\Messenger\QueryBus\QueryBus;
use Symfony\Component\Cache\Adapter\TagAwareAdapter;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

final class SymfonyMessengerQueryBus implements QueryBus
{
    use HandleTrait {
        handle as handleQuery;
    }

    public function __construct(
        MessageBusInterface $queryBus,
        private TagAwareCacheInterface $applicationQueryCachePool,
    ) {
        $this->messageBus = $queryBus;
    }

    public function handle(Query $query): mixed
    {
        return $this->handleQuery($query);
    }

    public function cacheExist(Query $query): bool
    {
        $cacheKey = $this->generateCacheKey($query);

        /** @var TagAwareAdapter $cacheAdapter */
        $cacheAdapter = $this->applicationQueryCachePool;

        return $cacheAdapter->hasItem($cacheKey);
    }

    private function generateCacheKey(Query $query): string
    {
        return md5(serialize($query));
    }
}