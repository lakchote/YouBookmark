<?php


namespace AppBundle\Service;


use AppBundle\Entity\Fichier;
use AppBundle\Entity\SousCategorie;
use Doctrine\ORM\EntityManager;

class DeleteService
{
	private $em;

	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	public function deleteFile(Fichier $fichier)
	{
		$dir = '/uploads/' . $fichier->getSousCategorie()->getCategorie()->getNom() . '/' . $fichier->getSousCategorie()->getNom();
		unlink(getcwd() . $dir . '/' . $fichier->getNom());
		$this->em->remove($fichier);
		$this->em->flush();
	}

	public function deleteDirectory(SousCategorie $sousCategorie)
	{
		$path = getcwd() . '/uploads/' . $sousCategorie->getCategorie()->getNom() . '/' . $sousCategorie->getNom();
		foreach($sousCategorie->getFichiers() as $fichier)
		{
			unlink($path . '/' . $fichier->getNom());
		}
		if(is_dir($path)) { 
		    rmdir($path);
        };
	}
}
