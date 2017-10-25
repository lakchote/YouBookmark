<?php


namespace AppBundle\Service;


use AppBundle\Entity\Fichier;
use AppBundle\Entity\SousCategorie;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
	private $targetPath;

	private $em;

	public function __construct($targetPath, EntityManager $em)
	{
		$this->targetPath = $targetPath;
		$this->em = $em;
	}

	public function uploadFile(Fichier $fichier, SousCategorie $sousCategorie)
	{
		$fichier->setSousCategorie($sousCategorie);
		$directoryCategoryRoot = $fichier->getSousCategorie()->getCategorie()->getNom();
		/** @var UploadedFile $file */
		$file = $fichier->getNom();
		$fichier->setNom( $file->getClientOriginalName());
		$file->move($this->targetPath . '/' . $directoryCategoryRoot . '/' . $sousCategorie->getNom(), $fichier->getNom());
		$this->em->persist($fichier);
		$this->em->flush();
	}
}
