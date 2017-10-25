<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\SousCategorie;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RemoveCategoryFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$builder
			->add('nom', EntityType::class, [
				'label' => 'Nom de la catégorie',
				'class' => 'AppBundle:SousCategorie',
				'choice_label' => 'nom',
				'multiple' => false,
				'expanded' => false,
				'query_builder' => function (EntityRepository $er) {
					return $er
						->createQueryBuilder('s')
						->orderBy('s.nom', 'ASC');
				}
			]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
		$resolver->setDefaults([
			'data_class' => SousCategorie::class
		]);
    }
}
