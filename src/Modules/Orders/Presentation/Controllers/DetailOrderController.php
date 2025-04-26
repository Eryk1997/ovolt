<?php

declare(strict_types=1);

namespace App\Modules\Orders\Presentation\Controllers;

use App\Modules\Orders\Application\Messenger\Queries\GetOrderDetailQuery;
use App\Modules\Orders\Domain\ValueObjects\OrderId;
use App\Modules\Orders\Presentation\Dtos\Response\DetailsOrder\OrderDetailResponse;
use App\Shared\Domain\Messenger\QueryBus\QueryBus;
use App\Shared\Presentation\Controllers\AbstractApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class DetailOrderController extends AbstractApiController
{
    #[Route('/orders/{id}', name: 'details', methods: ['GET'])]
    public function details(
        string $id,
        QueryBus $queryBus,
    ): JsonResponse
    {
        try {
            $result = $queryBus->handle(new GetOrderDetailQuery(OrderId::fromString($id)));

            return $this->successData('Order Details', OrderDetailResponse::fromOrderDetailDto($result));
        } catch (HandlerFailedException $exception) {
            return $this->successKnownIssueMessage($exception);
        }
    }
}