<?php


namespace AppBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

class FileDoesNotExistAlready extends Constraint
{
	public $message = 'Un fichier portant ce nom existe déjà.';
}
