<?php

declare(strict_types=1);

namespace App\Shared\Application\Validation\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\HttpFoundation\Response;

class ValidationFailedSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            ExceptionEvent::class => 'onException',
        ];
    }

    public function onException(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();

        if (!$throwable instanceof HttpExceptionInterface) {
            return;
        }

        $validationThrowable = $throwable->getPrevious();

        if (!$validationThrowable instanceof ValidationFailedException) {
            return;
        }

        $errors = [];

        foreach ($validationThrowable->getViolations() as $violation) {
            $errors[$violation->getPropertyPath()][] = $violation->getMessage();
        }

        $response = new JsonResponse(
            data: [
                'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'errors' => $errors,
            ],
            status: Response::HTTP_UNPROCESSABLE_ENTITY,
        );

        $event->setResponse($response);
    }
}