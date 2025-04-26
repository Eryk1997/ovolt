<?php

declare(strict_types=1);

namespace App\Modules\Orders\Presentation\Controllers;

use App\Modules\Orders\Application\Factories\UpdateOrderCommandFactory;
use App\Modules\Orders\Application\Provider\OrderProvider;
use App\Modules\Orders\Domain\ValueObjects\OrderId;
use App\Modules\Orders\Presentation\Dtos\Request\UpdateOrder\UpdateOrderRequest;
use App\Modules\Orders\Presentation\Dtos\Response\UpdateOrder\UpdateOrderResponse;
use App\Shared\Domain\Messenger\CommandBus\CommandBus;
use App\Shared\Presentation\Controllers\AbstractApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class UpdateOrderController extends AbstractApiController
{
    #[Route('/orders/{id}', name: 'update', methods: ['PATCH'])]
    public function update(
        #[MapRequestPayload]
        UpdateOrderRequest        $updateOrderRequest,
        string                    $id,
        CommandBus                $commandBus,
        UpdateOrderCommandFactory $updateOrderCommandFactory,
        OrderProvider $orderProvider,
    ): JsonResponse
    {
        try {
            $id = OrderId::fromString($id);
            $commandBus->dispatch($updateOrderCommandFactory->createFromRequest($id, $updateOrderRequest));
            $order = $orderProvider->findById($id);

            return $this->successData('Updated', UpdateOrderResponse::fromOrder($order));
        } catch (HandlerFailedException $exception) {
            return $this->successKnownIssueMessage($exception);
        }
    }
}