<?php


namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Categorie;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadCategories implements FixtureInterface
{

	public function load(ObjectManager $manager)
	{
		$categories = [
			'A',
			'B',
			'C',
			'D',
			'E',
			'F',
			'G',
			'H',
			'I',
			'J',
			'K',
			'L',
			'M',
			'N',
			'O',
			'P',
			'Q',
			'R',
			'S',
			'T',
			'U',
			'V',
			'W',
			'X',
			'Y',
			'Z'
		];

		foreach($categories as $lettreCategorie) {
			$categorie = new Categorie();
			$categorie->setNom($lettreCategorie);
			$manager->persist($categorie);
		}
		$manager->flush();
	}
}
