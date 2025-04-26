<?php

declare(strict_types=1);

namespace App\Modules\Orders\Application\Messenger\CommandHandlers;

use App\Modules\Orders\Application\Factories\OrderByCreateOrderCommandFactory;
use App\Modules\Orders\Application\Messenger\Commands\CreateOrder\CreateOrderCommand;
use App\Modules\Orders\Domain\Repositories\OrderRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class CreateOrderCommandHandler
{
    public function __construct(
        private OrderByCreateOrderCommandFactory $orderCommandFactory,
        private OrderRepositoryInterface         $orderRepository,
    )
    {
    }

    public function __invoke(CreateOrderCommand $createOrderCommand): void
    {
        $order = $this->orderCommandFactory->create($createOrderCommand);

        $this->orderRepository->save($order);
    }
}