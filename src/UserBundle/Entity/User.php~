<?php
// src/AppBundle/Entity/User.php

namespace UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        $this->roles = array('ROLE_USER');
    }
    /**
     * @var string
     *
     * @ORM\Column(name="user_familly_name", type="string", length=50)
     */
    private $userFamillyName;
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Commande", mappedBy="user", cascade={"remove"})
     */
    private $commandes;
    

    /**
     * Set userFamillyName.
     *
     * @param string $userFamillyName
     *
     * @return User
     */
    public function setUserFamillyName($userFamillyName)
    {
        $this->userFamillyName = $userFamillyName;

        return $this;
    }

    /**
     * Get userFamillyName.
     *
     * @return string
     */
    public function getUserFamillyName()
    {
        return $this->userFamillyName;
    }

    /**
     * Add commande.
     *
     * @param \UserBundle\Entity\Commande $commande
     *
     * @return User
     */
    public function addCommande(\UserBundle\Entity\Commande $commande)
    {
        $this->commandes[] = $commande;

        return $this;
    }

    /**
     * Remove commande.
     *
     * @param \UserBundle\Entity\Commande $commande
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeCommande(\UserBundle\Entity\Commande $commande)
    {
        return $this->commandes->removeElement($commande);
    }

    /**
     * Get commandes.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommandes()
    {
        return $this->commandes;
    }
}
