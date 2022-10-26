<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ValidDiscountCodeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) to take care of that
        if (null === $value || '' === $value) {
            return;
        }

        // Get current Event discounts linked to the subscription and compare wit the input promo code

        $currentEvent = $this->context->getRoot()->getData()->getEvent();
        $currentEventDiscounts = $currentEvent->getDiscounts();

        foreach($currentEventDiscounts as $discount) {
            if(strtoupper($value) == $discount->getCode())
            {
                return;
            }
        }

        /* @var $constraint App\Validator\ValidDiscountCode */

        $this->context->buildViolation($constraint->message)
            ->addViolation();
    }
}