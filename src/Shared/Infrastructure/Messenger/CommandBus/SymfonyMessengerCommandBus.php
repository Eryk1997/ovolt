<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Messenger\CommandBus;

use App\Shared\Domain\Messenger\CommandBus\Command;
use App\Shared\Domain\Messenger\CommandBus\CommandBus;
use Symfony\Component\Messenger\MessageBusInterface;

class SymfonyMessengerCommandBus implements CommandBus
{
    public function __construct(private readonly MessageBusInterface $commandBus)
    {
    }

    public function dispatch(Command $command): void
    {
        $this->commandBus->dispatch($command);
    }
}