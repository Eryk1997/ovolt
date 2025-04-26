<?php

declare(strict_types=1);

namespace App\Tests\Modules\Orders\Application\Messenger\CommandHandlers;

use App\Modules\Orders\Application\Messenger\CommandHandlers\UpdateOrderCommandHandler;
use App\Modules\Orders\Application\Messenger\Commands\UpdateOrder\UpdateOrderCommand;
use App\Modules\Orders\Application\Provider\OrderProviderInterface;
use App\Modules\Orders\Domain\Entity\Order;
use App\Modules\Orders\Domain\Enums\Status;
use App\Modules\Orders\Domain\Repositories\OrderRepositoryInterface;
use App\Modules\Orders\Domain\ValueObjects\OrderId;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UpdateOrderCommandHandlerTest extends TestCase
{
    private OrderRepositoryInterface&MockObject $orderRepository;
    private UpdateOrderCommandHandler $handler;
    private OrderProviderInterface&MockObject $orderProvider;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orderRepository = $this->createMock(OrderRepositoryInterface::class);
    }

    public function testItChangesOrderStatus(): void
    {
        $orderId = OrderId::fromString('01967119-a916-7c70-a9de-f086454a2338');
        $initialStatus = Status::NEW;
        $newStatus = Status::PAID->value;
        $command = new UpdateOrderCommand($orderId, $newStatus);

        $order = new Order($orderId->toUuid(), $initialStatus);

        $this->orderProvider = $this->createMock(OrderProviderInterface::class);
        $this->orderProvider->method('findById')->willReturn($order);

        $this->handler = new UpdateOrderCommandHandler(
            $this->orderProvider,
            $this->orderRepository,
        );

        $this->orderRepository
            ->expects(self::once())
            ->method('save')
            ->with($order);

        ($this->handler)($command);

        $this->assertSame(Status::PAID, $order->getStatus());
    }
}
