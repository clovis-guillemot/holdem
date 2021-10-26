<?php

namespace App\Entity\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class FiveCardsHandValidator extends ConstraintValidator
{

    /**
     * @inheritDoc
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof FiveCardsHand) {
            throw new UnexpectedTypeException($constraint, FiveCardsHand::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        if (!preg_match_all('/[2-9AKQJT][SHDC]/', $value, $matches) || count($matches[0]) != 5) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ hand }}', $value)
                ->addViolation();
        }
    }
}