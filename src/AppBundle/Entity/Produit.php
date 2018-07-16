<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produit
 *
 * @ORM\Table(name="produit")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProduitRepository")
 */
class Produit
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255, unique=true)
     */
    private $titre;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="stock", type="integer")
     */
    private $stock;

    /**
     * @var int
     *
     * @ORM\Column(name="prixTtc", type="integer")
     */
    private $prixTtc;
    
    /**
     * @ORM\ManyToOne(targetEntity="Genre", cascade="persist")
     * @ORM\JoinColumn(name="id_genre", referencedColumnName="id", nullable=true)
     */
    private $genre;
    
    /**
     * @ORM\ManyToOne(targetEntity="Types", cascade="persist")
     * @ORM\JoinColumn(name="id_types", referencedColumnName="id", nullable=true)
     */
    private $types;
    
    /**
     * @ORM\ManyToOne(targetEntity="Fournisseur", cascade="persist")
     * @ORM\JoinColumn(name="id_fournisseur", referencedColumnName="id", nullable=true)
     */
    private $fournisseur;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titre.
     *
     * @param string $titre
     *
     * @return Produit
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre.
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set description.
     *
     * @param string|null $description
     *
     * @return Produit
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set stock.
     *
     * @param int $stock
     *
     * @return Produit
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock.
     *
     * @return int
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set prixTtc.
     *
     * @param int $prixTtc
     *
     * @return Produit
     */
    public function setPrixTtc($prixTtc)
    {
        $this->prixTtc = $prixTtc;

        return $this;
    }

    /**
     * Get prixTtc.
     *
     * @return int
     */
    public function getPrixTtc()
    {
        return $this->prixTtc;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->commande = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set genre.
     *
     * @param \AppBundle\Entity\Genre|null $genre
     *
     * @return Produit
     */
    public function setGenre(\AppBundle\Entity\Genre $genre = null)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * Get genre.
     *
     * @return \AppBundle\Entity\Genre|null
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Set types.
     *
     * @param \AppBundle\Entity\Types|null $types
     *
     * @return Produit
     */
    public function setTypes(\AppBundle\Entity\Types $types = null)
    {
        $this->types = $types;

        return $this;
    }

    /**
     * Get types.
     *
     * @return \AppBundle\Entity\Types|null
     */
    public function getTypes()
    {
        return $this->types;
    }
    /**
     * Set fournisseur.
     *
     * @param \AppBundle\Entity\Fournisseur|null $fournisseur
     *
     * @return Produit
     */
    public function setFournisseur(\AppBundle\Entity\Fournisseur $fournisseur = null)
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    /**
     * Get fournisseur.
     *
     * @return \AppBundle\Entity\Fournisseur|null
     */
    public function getFournisseur()
    {
        return $this->fournisseur;
    }
}
