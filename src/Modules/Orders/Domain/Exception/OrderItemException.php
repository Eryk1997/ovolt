<?php

declare(strict_types=1);

namespace App\Modules\Orders\Domain\Exception;

use DomainException;

class OrderItemException extends DomainException
{
    public function __construct(string $translationKey, array $params = [], \Throwable $previous = null)
    {
        $message = json_encode([
            'key' => $translationKey,
            'params' => $params,
        ]);

        parent::__construct($message, 0, $previous);
    }
}