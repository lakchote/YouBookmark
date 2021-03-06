<?php


namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FichierRepository")
 * @ORM\Table(name="fichier")
 */
class Fichier
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", unique=true)
	 * @Assert\File(mimeTypes={"image/jpeg", "image/png", "application/pdf"})
	 *
	 */
	private $nom;


	/**
	 * @ORM\ManyToOne(targetEntity="SousCategorie", inversedBy="fichiers")
	 */
	private $sousCategorie;


	/**
	 * @ORM\Column(type="datetime")
	 */
	private $dateUpload;

	public function __construct()
	{
		$this->dateUpload = new \DateTime();
	}

	/**
	 * @return integer
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getNom()
	{
		return $this->nom;
	}

	/**
	 * @param string $nom
	 */
	public function setNom($nom)
	{
		$this->nom = $nom;
	}

	/**
	 * @return SousCategorie
	 */
	public function getSousCategorie()
	{
		return $this->sousCategorie;
	}

	/**
	 * @param SousCategorie $sousCategorie
	 */
	public function setSousCategorie(SousCategorie $sousCategorie)
	{
		$this->sousCategorie = $sousCategorie;
	}

	/**
	 * @return mixed
	 */
	public function getDateUpload()
	{
		return $this->dateUpload;
	}

}
