<?php


namespace AppBundle\Validator\Constraints;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class FileDoesNotExistAlreadyValidator extends ConstraintValidator
{

	private $em;

	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	public function validate($value, Constraint $constraint)
	{
		if($this->em->getRepository('AppBundle:Fichier')->findOneBy([
			'nom' => $value->getClientOriginalName()
		])) {
			$this->context->buildViolation($constraint->message)->addViolation();
		}
	}

}
