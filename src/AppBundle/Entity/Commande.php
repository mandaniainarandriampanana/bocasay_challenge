<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommandeRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Commande
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
     * @var int
     *
     * @ORM\Column(name="somme", type="integer")
     */
    private $somme;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;
    
    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="commandes", cascade="persist")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id", nullable=true)
     */
    private $user;
    
    /**
     * @ORM\ManyToMany(targetEntity="Produit",inversedBy="commande",cascade={"persist"})
     */
    protected $produit;

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
     * Set somme.
     *
     * @param int $somme
     *
     * @return Commande
     */
    public function setSomme($somme)
    {
        $this->somme = $somme;

        return $this;
    }

    /**
     * Get somme.
     *
     * @return int
     */
    public function getSomme()
    {
        return $this->somme;
    }

    /**
     * Set user.
     *
     * @param \UserBundle\Entity\Cmmande|null $user
     *
     * @return Commande
     */
    public function setUser(\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \UserBundle\Entity\Cmmande|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->produit = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add produit.
     *
     * @param \AppBundle\Entity\Produit $produit
     *
     * @return Commande
     */
    public function addProduit(\AppBundle\Entity\Produit $produit)
    {
        $this->produit[] = $produit;

        return $this;
    }

    /**
     * Remove produit.
     *
     * @param \AppBundle\Entity\Produit $produit
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeProduit(\AppBundle\Entity\Produit $produit)
    {
        return $this->produit->removeElement($produit);
    }

    /**
     * Get produit.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProduit()
    {
        return $this->produit;
    }
    
    /**
     * Set produit.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function setProduit(\AppBundle\Entity\Produit $produit)
    {
        $this->produit[] = $produit;

        return $this;
    }
    
    /**
     * @ORM\PrePersist()
     */
    public function filSexeDate() {
        $now = new \DateTime('now');
        $this->date = $now;
    }

    /**
     * Set date.
     *
     * @param \DateTime|null $date
     *
     * @return Commande
     */
    public function setDate($date = null)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return \DateTime|null
     */
    public function getDate()
    {
        return $this->date;
    }
}
