<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\SousCategorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddCategoryFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$builder->add('nom', TextType::class, [
			'label' => 'Nom de la catégorie'
		]);
		$builder->add('categorie',EntityType::class, [
			'label' => 'Domaine',
			'class' => 'AppBundle\Entity\Categorie',
			'choice_label' => 'nom',
			'disabled' => true
		]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
		$resolver->setDefaults([
			'data_class' => SousCategorie::class,
			'validation_groups' => ['Default', 'AddCategory']

		]);
    }
}
