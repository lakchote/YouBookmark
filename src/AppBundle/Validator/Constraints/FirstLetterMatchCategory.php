<?php


namespace AppBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class FirstLetterMatchCategory extends Constraint
{
	public $message = 'La première lettre de la sous-catégorie doit correspondre à celle de la catégorie.';
}
