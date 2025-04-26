<?php

declare(strict_types=1);

namespace App\Modules\Orders\Application\Messenger\CommandHandlers;

use App\Modules\Orders\Application\Messenger\Commands\UpdateOrder\UpdateOrderCommand;
use App\Modules\Orders\Application\Provider\OrderProvider;
use App\Modules\Orders\Application\Provider\OrderProviderInterface;
use App\Modules\Orders\Domain\Enums\Status;
use App\Modules\Orders\Domain\Repositories\OrderRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class UpdateOrderCommandHandler
{
    public function __construct(
        private OrderProviderInterface   $orderProvider,
        private OrderRepositoryInterface $orderRepository,
    )
    {
    }

    public function __invoke(UpdateOrderCommand $command): void
    {
        $order = $this->orderProvider->findById($command->orderId);

        $order->setStatus(Status::from($command->status));

        $this->orderRepository->save($order);
    }
}