<?php


namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class SousCategorieRepository extends EntityRepository
{
	public function getSousCategoriesForACategorie($nomCategorie)
	{
		return $this
			->createQueryBuilder('s')
			->select('s.nom AS label')
			->where('s.nom LIKE :nomCategorie')
			->setParameter('nomCategorie', $nomCategorie . '%')
			->getQuery()
			->getResult();
	}
}
