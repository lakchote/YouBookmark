<?php


namespace AppBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategorieRepository")
 * @ORM\Table(name="categorie")
 */
class Categorie
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=1)
	 */
	private $nom;

	/**
	 * @ORM\OneToMany(targetEntity="SousCategorie", mappedBy="categorie")
	 */
	private $sousCategorie;

	public function __construct()
	{
		$this->sousCategorie = new ArrayCollection();
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
	 * @return ArrayCollection|SousCategorie[]
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
		$this->sousCategorie->add($sousCategorie);
	}

}

