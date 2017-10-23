<?php


namespace AppBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Validator\Constraints as AssertCustom;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SousCategorieRepository")
 * @ORM\Table(name="sous_categorie")
 */
class SousCategorie
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string")
	 * @Assert\Length(min=2, minMessage="La sous-catégorie doit faire au moins 2 caractères.")
	 * @Assert\NotBlank()
	 * @AssertCustom\FirstLetterMatchCategory()
	 */
	private $nom;

	/**
	 * @ORM\ManyToOne(targetEntity="Categorie", inversedBy="sousCategorie")
	 */
	private $categorie;

	/**
	 * @ORM\OneToMany(targetEntity="Fichier", mappedBy="sousCategorie", cascade={"remove"})
	 * @ORM\JoinColumn(nullable=true)
	 */
	private $fichiers;

	public function __construct()
	{
		$this->fichiers = new ArrayCollection();
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
		$nom = strtolower($nom);
		$this->nom = ucfirst($nom);
	}

	/**
	 * @return Categorie
	 */
	public function getCategorie()
	{
		return $this->categorie;
	}

	/**
	 * @param Categorie $categorie
	 */
	public function setCategorie(Categorie $categorie)
	{
		$this->categorie = $categorie;
	}

	/**
	 * @return ArrayCollection|Fichier[]
	 */
	public function getFichiers()
	{
		return $this->fichiers;
	}

	/**
	 * @param Fichier $fichier
	 */
	public function setFichiers(Fichier $fichier)
	{
		$this->fichiers->add($fichier);
	}

}
