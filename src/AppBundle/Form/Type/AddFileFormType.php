<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Fichier;
use AppBundle\Validator\Constraints\FileDoesNotExistAlready;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddFileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$builder
			->add('nom', FileType::class, [
				'label' => 'Fichier à envoyer',
				'attr' => ['class' => 'btn-upload--cta'],
				'constraints' => [new FileDoesNotExistAlready()]
			]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
		$resolver->setDefaults([
			'data_class' => Fichier::class
		]);
    }
}
