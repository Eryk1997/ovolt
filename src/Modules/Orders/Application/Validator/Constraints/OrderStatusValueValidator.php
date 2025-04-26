<?php

declare(strict_types=1);

namespace App\Modules\Orders\Application\Validator\Constraints;

use App\Modules\Orders\Domain\Enums\Status;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Contracts\Translation\TranslatorInterface;

#[\Attribute]
class OrderStatusValueValidator extends ConstraintValidator
{
    public function __construct(
        private readonly TranslatorInterface $translator,
    )
    {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof OrderStatusValue) {
            throw new UnexpectedTypeException($constraint, OrderStatusValue::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        $status = Status::tryFrom($value);

        if ($status === null) {
            $translatedMessage = $this->translator->trans("order.status.valid_option", ['%status%' => $value], 'exceptions');

            $this->context->buildViolation($translatedMessage)
                ->addViolation();
        }
    }
}