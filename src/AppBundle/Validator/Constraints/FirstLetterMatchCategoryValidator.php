<?php


namespace AppBundle\Validator\Constraints;


use AppBundle\Entity\SousCategorie;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class FirstLetterMatchCategoryValidator extends ConstraintValidator
{
	public function validate($value, Constraint $constraint)
	{
		/**
		 * @var SousCategorie $data
		 */
		$data = $this->context->getObject();
		if(substr($value, 0, 1) !== $data->getCategorie()->getNom()) {
			$this->context->buildViolation($constraint->message)->addViolation();
		}
	}

}
