<?php


namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class FichierRepository extends EntityRepository
{
	public function getFilesForASousCategorie($nom)
	{
		return $this
			->createQueryBuilder('f')
			->innerJoin('f.sousCategorie', 's')
			->where('s.nom = :nom')
			->orderBy('f.nom', 'ASC')
			->setParameter('nom', $nom)
			->getQuery()
			->getResult();
	}
}
