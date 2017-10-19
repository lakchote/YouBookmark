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
		 * @var SousCategorie $sousCategorie
		 */
		$sousCategorie = $this->context->getObject();
		$lettreCategorie = substr($sousCategorie->getCategorie()->getNom(), 0, 1);
		$lettreSousCategorie = substr($sousCategorie->getNom(), 0,1);
		if($lettreCategorie !== $lettreSousCategorie) {
			$this->context->buildViolation($constraint->message)->addViolation();
		}
	}

}
