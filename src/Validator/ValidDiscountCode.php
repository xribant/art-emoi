<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "ANNOTATION"})
 */
class ValidDiscountCode extends Constraint
{
    /*
    * Any public properties become valid options for the annotation.
    * Then, use these in your validator class.
    */
    public $message = 'Ce code n\'est pas valide';
}