<?php

declare(strict_types=1);

namespace App\Modules\Orders\Presentation\Controllers;

use App\Modules\Orders\Application\Factories\CreateOrderCommandFactory;
use App\Modules\Orders\Application\Provider\OrderProvider;
use App\Modules\Orders\Domain\ValueObjects\OrderId;
use App\Modules\Orders\Presentation\Dtos\Request\CreateOrder\CreateOrderRequest;
use App\Modules\Orders\Presentation\Dtos\Response\CreateOrder\CreateOrderResponse;
use App\Shared\Domain\Messenger\CommandBus\CommandBus;
use App\Shared\Presentation\Controllers\AbstractApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class CreateOrderController extends AbstractApiController
{
    #[Route('/orders', name: 'create', methods: ['POST'])]
    public function create(
        #[MapRequestPayload]
        CreateOrderRequest        $createOrderRequest,
        CommandBus                $commandBus,
        CreateOrderCommandFactory $createOrderCommandFactory,
        OrderProvider $orderProvider,
    ): JsonResponse
    {
        try {
            $id = OrderId::new();
            $commandBus->dispatch($createOrderCommandFactory->createFromRequest($id, $createOrderRequest));
            $order = $orderProvider->findById($id);

            return $this->successData('Created', CreateOrderResponse::fromOrder($order));
        } catch (HandlerFailedException $exception) {
            return $this->successKnownIssueMessage($exception);
        }
    }
}