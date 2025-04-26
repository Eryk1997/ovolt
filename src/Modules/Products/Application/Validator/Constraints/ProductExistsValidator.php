<?php

declare(strict_types=1);

namespace App\Modules\Products\Application\Validator\Constraints;

use App\Modules\Products\Application\Exception\NotFoundProductException;
use App\Modules\Products\Application\Provider\ProductProvider;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Symfony\Contracts\Translation\TranslatorInterface;

class ProductExistsValidator extends ConstraintValidator
{
    public function __construct(
        private readonly ProductProvider $productProvider,
        private readonly TranslatorInterface $translator,
    ) {}

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof ProductExists) {
            throw new UnexpectedTypeException($constraint, ProductExists::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_numeric($value)) {
            throw new UnexpectedValueException($value, 'numeric');
        }

        try {
            $this->productProvider->findById((int) $value);
        } catch (NotFoundProductException $exception) {
            $translatedMessage = '';

            if ($exception->getMessage()) {
                $data = json_decode($exception->getMessage(), true);
                if (is_array($data) && isset($data['key'])) {
                    $translatedMessage = $this->translator->trans($data['key'], $data['params'] ?? [], 'exceptions');
                }
            }

            $this->context->buildViolation($translatedMessage)
                ->addViolation();
        }
    }
}